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

    // ✅ SET SESSION ERROR MESSAGE
    $_SESSION['error'] = "You do not have access to that page.";

    $path = role_dashboard_path($_SESSION['role']);

    // ✅ REDIRECT WITHOUT GET PARAM
    header('Location: ' . APP_BASE . '/' . $path);
    exit();
}

}
