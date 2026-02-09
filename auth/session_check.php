<?php
session_start();

$response = [
    "logged" => false,
    "role" => null
];

if (isset($_SESSION['user_id'])) {
    $response["logged"] = true;
    $response["role"] = $_SESSION['user_role'];
}

header('Content-Type: application/json');
echo json_encode($response);
