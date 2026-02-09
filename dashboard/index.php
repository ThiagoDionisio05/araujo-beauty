<?php
require_once '../auth/protect.php';
protect('admin');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Inicia sessão apenas se ainda não houver
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once '../config/database.php';

$adm_id = $_SESSION['user_id'] ?? 0;
$first_name = $_SESSION['first_name'] ?? 'Administrador';
$msg = "";

// Processar criação de agendamento manual
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cliente_id = $_POST['cliente_id'] ?? 0; // 0 = bloqueio
    $servico_id = $_POST['servico_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Verifica se horário está livre
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE adm_id=? AND data=? AND horario=?");
    $stmt->execute([$adm_id, $data, $horario]);
    if($stmt->fetchColumn() > 0){
        $msg = "Horário já ocupado!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO agendamentos(cliente_id, servico_id, data, horario, adm_id, status)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $status = ($cliente_id == 0) ? 'cancelado' : 'pendente';
        $stmt->execute([$cliente_id, $servico_id, $data, $horario, $adm_id, $status]);
        $msg = ($cliente_id == 0) ? "Horário bloqueado com sucesso!" : "Agendamento adicionado!";
    }
}

// Buscar agendamentos do ADM
$stmt = $pdo->prepare("
    SELECT a.id, a.data, a.horario, a.status, 
           u.first_name AS cliente_first, u.last_name AS cliente_last,
           s.nome AS servico
    FROM agendamentos a
    LEFT JOIN users u ON a.cliente_id = u.id
    JOIN servicos s ON a.servico_id = s.id
    WHERE a.adm_id = ?
    ORDER BY a.data ASC, a.horario ASC
");
$stmt->execute([$adm_id]);
$agendamentos = $stmt->fetchAll();

// Buscar serviços do ADM
$stmt = $pdo->prepare("SELECT id, nome FROM servicos WHERE adm_id = ?");
$stmt->execute([$adm_id]);
$servicos_adm = $stmt->fetchAll();

// Buscar clientes (exclui admins)
$stmt = $pdo->query("SELECT id, first_name, last_name FROM users WHERE role='cliente'");
$clientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Administrativo - <?= htmlspecialchars($first_name) ?></title>
<link rel="stylesheet" href="../assets/css/dashboard.css">

</head>
<body>

<main class="dashboard-container">
    <h1 class="dashboard-title">Agenda de <?= htmlspecialchars($first_name) ?></h1>

    <form method="POST" class="dashboard-form">
        <h2>Adicionar Agendamento / Bloquear Horário</h2>

        <label for="servico_id">Serviço:</label>
        <select name="servico_id" id="servico_id" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach($servicos_adm as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="cliente_id">Cliente (ou selecione "Bloquear"):</label>
        <select name="cliente_id" id="cliente_id" class="form-select">
            <option value="0">Bloquear</option>
            <?php foreach($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['first_name'].' '.$c['last_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" class="form-input" required min="<?= date('Y-m-d') ?>">

        <label for="horario">Horário:</label>
        <input type="time" name="horario" id="horario" class="form-input" required min="08:00" max="18:00" step="3600">

        <button type="submit" class="btn-agendar">Salvar</button>
        <div id="msg" class="form-msg"><?= htmlspecialchars($msg) ?></div>
    </form>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Cliente</th>
                <th>Serviço</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($agendamentos) === 0): ?>
            <tr>
                <td colspan="5" style="text-align:center;">Nenhum agendamento encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach($agendamentos as $a): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($a['data'])) ?></td>
                <td><?= date('H:i', strtotime($a['horario'])) ?></td>
                <td><?= htmlspecialchars($a['cliente_first'] ?? 'Indisponível') ?></td>
                <td><?= htmlspecialchars($a['servico']) ?></td>
                <td><?= ucfirst(htmlspecialchars($a['status'])) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>




