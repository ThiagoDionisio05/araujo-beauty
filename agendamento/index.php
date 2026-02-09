<?php
require_once '../auth/protect.php';
protect('cliente');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

// Buscar serviços disponíveis
$stmt = $pdo->query("SELECT s.id, s.nome, u.first_name, u.last_name 
                     FROM servicos s
                     JOIN users u ON s.adm_id = u.id");
$servicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Agendamento - Araujo Beauty</title>
<link rel="stylesheet" href="../assets/css/agendamento.css">
</head>
<body>

<main class="agendamento-container">
    <h1 class="agendamento-title">Agendamento de Serviços</h1>

    <form id="form-agendamento" class="agendamento-form">
        <div class="form-group">
            <label for="servico">Escolha o serviço:</label>
            <select id="servico" name="servico" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach($servicos as $s): ?>
                    <option value="<?= $s['id'] ?>" data-adm="<?= $s['first_name'] ?>"><?= $s['nome'] ?> - <?= $s['first_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="data">Escolha o dia:</label>
            <input type="date" id="data" name="data" class="form-input" required min="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label for="horario">Horário disponível:</label>
            <select id="horario" name="horario" class="form-select" required>
                <option value="">Selecione o serviço e data</option>
            </select>
        </div>

        <button type="submit" class="btn-agendar">Agendar</button>
    </form>

    <div id="msg" class="agendamento-msg"></div>
</main>

<script>
const servicoSelect = document.getElementById('servico');
const dataInput = document.getElementById('data');
const horarioSelect = document.getElementById('horario');
const form = document.getElementById('form-agendamento');
const msg = document.getElementById('msg');

async function fetchHorarios(){
    const servico = servicoSelect.value;
    const data = dataInput.value;
    if(!servico || !data) return;

    const res = await fetch('get_horarios.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({servico, data})
    });
    const horarios = await res.json();
    horarioSelect.innerHTML = '<option value="">Selecione</option>';
    horarios.forEach(h => {
        const opt = document.createElement('option');
        opt.value = h;
        opt.textContent = h;
        horarioSelect.appendChild(opt);
    });
}

servicoSelect.addEventListener('change', fetchHorarios);
dataInput.addEventListener('change', fetchHorarios);

form.addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch('get_horarios.php', {
        method: 'POST',
        body: formData
    });
    const result = await res.json();
    msg.textContent = result.msg;
    if(result.success) form.reset();
});
</script>
</body>
</html>
