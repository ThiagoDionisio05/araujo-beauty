<?php
session_start();
require_once '../config/database.php';

$input = file_get_contents('php://input');
$dataJson = json_decode($input, true);

if($dataJson){ // chamada AJAX
    $servico_id = $dataJson['servico'];
    $data = $dataJson['data'];

    // Buscar o adm que realiza o serviço
    $stmt = $pdo->prepare("SELECT adm_id FROM servicos WHERE id = ?");
    $stmt->execute([$servico_id]);
    $adm_id = $stmt->fetchColumn();

    // Horários já agendados
    $stmt2 = $pdo->prepare("SELECT horario FROM agendamentos WHERE adm_id = ? AND data = ?");
    $stmt2->execute([$adm_id, $data]);
    $ocupados = $stmt2->fetchAll(PDO::FETCH_COLUMN);

    // Gerar horários das 08:00 às 18:00
    $horarios = [];
    for($h=8; $h<18; $h++){
        $hora = sprintf("%02d:00:00", $h);
        if(!in_array($hora, $ocupados)) $horarios[] = $hora;
    }

    echo json_encode($horarios);
    exit;
}

// Submissão do formulário
if($_POST){
    $cliente_id = $_SESSION['user_id'];
    $servico_id = $_POST['servico'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Buscar o adm
    $stmt = $pdo->prepare("SELECT adm_id FROM servicos WHERE id=?");
    $stmt->execute([$servico_id]);
    $adm_id = $stmt->fetchColumn();

    // Verificar se horário ainda está livre
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE adm_id=? AND data=? AND horario=?");
    $stmt->execute([$adm_id, $data, $horario]);
    if($stmt->fetchColumn() > 0){
        echo json_encode(['success'=>false,'msg'=>'Horário já ocupado']);
        exit;
    }

    // Inserir agendamento
    $stmt = $pdo->prepare("INSERT INTO agendamentos(cliente_id, servico_id, data, horario, adm_id) VALUES (?,?,?,?,?)");
    $stmt->execute([$cliente_id, $servico_id, $data, $horario, $adm_id]);

    echo json_encode(['success'=>true,'msg'=>'Agendamento realizado com sucesso!']);
    exit;
}

