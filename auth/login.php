<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? 'login';

    // ================= LOGIN =================
    if ($action === 'login') {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: ../index.php");
            exit;
        } else {
            $error = "E-mail ou senha inválidos.";
        }
    }

    // ================= CADASTRO =================
    if ($action === 'register') {

        $first = $_POST['first_name'] ?? '';
        $last  = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($first && $last && $email && $phone && $password) {

            $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);

            if ($check->fetch()) {
                $error = "Este e-mail já está cadastrado.";
            } else {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO users 
                    (first_name, last_name, email, phone, password_hash, role, is_verified)
                    VALUES (?, ?, ?, ?, ?, 'cliente', 0)
                ");

                $stmt->execute([$first, $last, $email, $phone, $hash]);

                $success = "Conta criada! Faça login para continuar.";
            }
        } else {
            $error = "Preencha todos os campos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Acesso - Araujo Beauty</title>
<link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

<section class="auth-section">
    <div class="auth-container">

        <h2 id="auth-title" class="auth-title">Fazer Login</h2>

        <?php if ($error): ?>
            <div class="auth-message error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="auth-message success">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="authForm" class="auth-form">

            <input type="hidden" name="action" id="action" value="login">

            <div id="registerFields" class="register-fields">
                <input class="auth-input" type="text" name="first_name" placeholder="Nome">
                <input class="auth-input" type="text" name="last_name" placeholder="Sobrenome">
                <input class="auth-input" type="tel" name="phone" placeholder="Telefone com DDD">
            </div>

            <input class="auth-input" type="email" name="email" placeholder="E-mail" required>
            <input class="auth-input" type="password" name="password" placeholder="Senha" required>

            <button class="auth-btn" type="submit" id="submitBtn">
                Entrar
            </button>

        </form>

        <p id="toggleText" class="auth-switch">
            Não tem conta?
            <a href="#" id="toggleAuth">Cadastre-se</a>
        </p>

    </div>
</section>

<script src="../assets/js/auth.js"></script>
</body>
</html>
