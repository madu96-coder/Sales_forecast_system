<?php
// app base use for correct path of file project

if (!defined('APP_BASE')) {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''); //get current script path
    $dir = dirname($script); //get directory path

    $nested = basename($dir); //get last folder name
    $roleFolders = ['admin', 'sales_manager', 'product_manager', 'inventory_manager']; //list of role folders
    if (in_array($nested, $roleFolders, true)) {
        $dir = dirname($dir);
    }
    $base = $dir === '/' || $dir === '.' ? '' : rtrim($dir, '/');
    define('APP_BASE', $base);
}

//connect to mysql database
$conn = mysqli_connect("localhost","root","","sales_forecast");

// check if connection failed
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());

}

// if successful, connection is ready to use
?>