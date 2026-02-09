<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
MODOS DE PROTEÇÃO:

protect();            -> qualquer usuário logado
protect('admin');     -> somente admin
protect('cliente');   -> somente cliente
*/

function protect($role = null) {

    // ❌ Não logado
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    // 🔐 Verificação de nível (RBAC)
    if ($role && $_SESSION['user_role'] !== $role) {

        // Se tentar acessar área errada
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: ../dashboard/index.php");
        } else {
            header("Location: ../agendamento/index.php");
        }

        exit;
    }
}
