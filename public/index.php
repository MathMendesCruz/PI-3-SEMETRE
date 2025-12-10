<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 🔥 FIX CRÍTICO: Remover cache SQLite ANTES de carregar qualquer coisa
$cache_files = [
    __DIR__.'/../bootstrap/cache/config.php',
    __DIR__.'/../bootstrap/cache/services.php',
    __DIR__.'/../bootstrap/cache/packages.php',
];

$cache_cleared = false;
foreach ($cache_files as $cache_file) {
    if (file_exists($cache_file)) {
        $content = file_get_contents($cache_file);
        // Se detectar 'sqlite' no cache, remover TUDO
        if (stripos($content, "'sqlite'") !== false || stripos($content, '"sqlite"') !== false) {
            @unlink($cache_file);
            $cache_cleared = true;
        }
    }
}

// Se limpou cache, redirecionar para recarregar
if ($cache_cleared && !isset($_GET['cache_cleared'])) {
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?cache_cleared=1');
    exit('🔄 Cache SQLite detectado e removido. Recarregando com MySQL...');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
