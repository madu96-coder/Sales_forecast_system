<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/roles.php';

if (isset($_SESSION['user_id'])) {
    $role = normalize_user_role($_SESSION['role'] ?? '');
    $dash = role_dashboard_path($role);
    header('Location: ' . APP_BASE . '/' . $dash);
    exit();
} else {
    header('Location: ' . APP_BASE . '/login.php');
    exit();
}