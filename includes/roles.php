<?php

// normalize user roles
function normalize_user_role($role)
{
    if ($role === null || $role === '') {
        return '';
    }
    $r = strtolower(trim(preg_replace('/\s+/', '_', (string) $role)));
    $aliases = [
        'salesmanager' => 'sales_manager',
        'sales_manager' => 'sales_manager',
        'productmanager' => 'product_manager',
        'product_manager' => 'product_manager',
        'production_manager' => 'product_manager',
        'inventorymanager' => 'inventory_manager',
        'inventory_manager' => 'inventory_manager',
    ];
    if (isset($aliases[$r])) {
        return $aliases[$r];
    }
    return $r;
}

// dashboard entry roles
function role_dashboard_path($role)
{
    $role = normalize_user_role($role);
    switch ($role) {
        case 'admin':
            return 'admin/dashboard.php';
        case 'sales_manager':
            return 'sales_manager/dashboard.php';
        case 'product_manager':
            return 'product_manager/dashboard.php';
        case 'inventory_manager':
            return 'inventory_manager/dashboard.php';
        default:
            return 'login.php';
    }
}
