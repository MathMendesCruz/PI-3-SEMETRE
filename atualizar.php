<?php
/**
 * Script Definitivo de Atualização
 * 1. Remove cache antigo
 * 2. Lê o .env correto
 * 3. Cria novo cache com MySQL
 * 
 * Acesse: https://seu-dominio.com.br/atualizar.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Atualização - Elegance Joias</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 20px auto; background: #f9f9f9; }
        .container { background: white; padding: 20px; border-radius: 10px; }
        .ok { color: green; font-weight: bold; }
        .erro { color: red; font-weight: bold; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔄 Atualização de Configuração</h1>
    
    <?php
    
    echo "<h2>Passo 1: Remover Cache Antigo</h2>";
    
    // Remover cache forçadamente
    $cache_dirs = ['bootstrap/cache', 'storage/framework/cache', 'storage/framework/views'];
    foreach ($cache_dirs as $dir) {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;
                if (is_file($path)) {
                    @unlink($path);
                    echo "✅ Removido: $file<br>";
                }
            }
        }
    }
    
    echo "<h2>Passo 2: Verificar .env</h2>";
    
    // Ler .env manualmente
    $env_content = file_get_contents('.env');
    $lines = explode("\n", $env_content);
    
    $db_config = [];
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0 && strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $db_config[trim($key)] = trim($value);
            echo "✅ " . trim($key) . " = " . trim($value) . "<br>";
        }
    }
    
    echo "<h2>Passo 3: Criar Cache Novo com Laravel</h2>";
    
    // Carregar Laravel e criar cache
    try {
        require_once 'vendor/autoload.php';
        
        // Limpar variáveis de ambiente do PHP para forçar releitura
        putenv('DB_CONNECTION=');
        putenv('DB_HOST=');
        putenv('DB_DATABASE=');
        putenv('DB_USERNAME=');
        putenv('DB_PASSWORD=');
        
        // Recarregar .env
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        @$dotenv->load();
        
        // Inicializar app
        $app = require_once 'bootstrap/app.php';
        $app->make('config');
        
        // Executar artisan commands
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        
        echo "Executando: config:cache<br>";
        ob_start();
        $kernel->call('config:cache');
        $output = ob_get_clean();
        echo "<pre>$output</pre>";
        
        echo "<span class='ok'>✅ Config cache criado!</span><br>";
        
    } catch (Exception $e) {
        echo "<span class='erro'>❌ Erro: " . $e->getMessage() . "</span><br>";
    }
    
    echo "<h2>✅ Pronto!</h2>";
    echo "Aguarde 5 segundos e a página será redirecionada...<br>";
    echo "<meta http-equiv='refresh' content='5;url=/'>";
    
    ?>
</div>
</body>
</html>
