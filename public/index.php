<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// 🔥 FIX: Limpar cache se detectar configuração SQLite
$cache_config = __DIR__.'/../bootstrap/cache/config.php';
if (file_exists($cache_config)) {
    $cached = require $cache_config;
    if (isset($cached['database.default']) && $cached['database.default'] === 'sqlite') {
        // Cache com SQLite detectado! Remover para forçar releitura do .env
        @unlink($cache_config);
        @unlink(__DIR__.'/../bootstrap/cache/services.php');
        @unlink(__DIR__.'/../bootstrap/cache/packages.php');
        // Redirecionar para recarregar
        if (!isset($_GET['_reloaded'])) {
            header('Location: ' . $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') !== false ? '&' : '?') . '_reloaded=1');
            exit('🔄 Limpando cache SQLite... Recarregando...');
        }
    }
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
