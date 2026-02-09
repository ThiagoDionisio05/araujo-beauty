<?php
session_start();
require_once '../auth/protect.php';
protect('admin');
require_once 'database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$adm_id = $_SESSION['user_id'] ?? 0;
$servico_id = $data['servico_id'];
$cliente_id = $data['cliente_id'];
$data_hora = $data['data_hora'];

if(!$servico_id || !$data_hora){
    echo json_encode(['success'=>false,'msg'=>'Preencha todos os campos.']);
    exit;
}

list($data, $horario) = explode('T', $data_hora);

$stmt = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE adm_id=? AND data=? AND horario=?");
$stmt->execute([$adm_id, $data, $horario]);
if($stmt->fetchColumn() > 0){
    echo json_encode(['success'=>false,'msg'=>'Horário já ocupado']);
    exit;
}

$status = ($cliente_id==0)?'cancelado':'pendente';
$stmt = $pdo->prepare("INSERT INTO agendamentos(cliente_id, servico_id, data, horario, adm_id, status) VALUES (?,?,?,?,?,?)");
$stmt->execute([$cliente_id, $servico_id, $data, $horario, $adm_id, $status]);

echo json_encode(['success'=>true,'msg'=>'Agendamento salvo com sucesso!']);
