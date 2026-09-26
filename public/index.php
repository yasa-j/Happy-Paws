<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Start output buffering and user session
session_start();

// Load Config file
require_once '../config/config.php';

// Autoload Core Libraries (Database, Controller, Router)
spl_autoload_register(function ($className) {
    $file = APPROOT . '/core/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
//instead of require_once each core files, this autoloader loads them as it requires

// Initialize Router App
$app = new Router();
