<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Determine if the application is in maintenance mode...
$maintenancePaths = [
    __DIR__.'/../storage/framework/maintenance.php',
    __DIR__.'/../../zankidausat/storage/framework/maintenance.php',
];
foreach ($maintenancePaths as $path) {
    if (file_exists($path)) {
        require $path;
        break;
    }
}

// Register the Composer autoloader...
$autoloadPaths = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../zankidausat/vendor/autoload.php',
];
foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require $path;
        break;
    }
}

// Bootstrap Laravel and handle the request...
$appPaths = [
    __DIR__.'/../bootstrap/app.php',
    __DIR__.'/../../zankidausat/bootstrap/app.php',
];
foreach ($appPaths as $path) {
    if (file_exists($path)) {
        $app = require_once $path;
        break;
    }
}

if (!isset($app)) {
    die("Error: Could not find bootstrap/app.php");
}

$app->handleRequest(Request::capture());
