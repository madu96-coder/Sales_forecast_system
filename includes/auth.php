<?php
session_start();

require_once __DIR__ . '/config.php';//db connect
require_once __DIR__ . '/roles.php'; //access based on roles

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . APP_BASE . '/login.php');
    exit();
}

if (isset($_SESSION['role'])) {
    $_SESSION['role'] = normalize_user_role($_SESSION['role']);
}

function checkRole($allowedRoles = [])
{
    if (!in_array($_SESSION['role'], $allowedRoles, true)) {
        $path = role_dashboard_path($_SESSION['role']);
        header('Location: ' . APP_BASE . '/' . $path . '?access_denied=1');
        exit();
    }
}
