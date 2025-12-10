<?php
/**
 * Script de Pós-Deploy
 * Execute via navegador: https://seu-dominio.com.br/post-deploy.php
 *
 * Este script executa as ações necessárias após fazer push no Hostinger
 */

// Evitar acesso direto
if (php_sapi_name() === 'cli') {
    echo "❌ Este script deve ser acessado via navegador ou GET request\n";
    exit(1);
}

// Verificar token de segurança
$token = $_GET['token'] ?? '';
$expected_token = md5('elegance_joias_deploy_2025');

if ($token !== $expected_token) {
    http_response_code(403);
    die("❌ Token inválido. Acesso negado.\n");
}

// Função para executar comando
function run_command($command, $description) {
    echo "<strong>▶ $description</strong><br>";
    $output = shell_exec("$command 2>&1");
    echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px;'>$output</pre>";
    echo "<br>";
}

// Função para verificar erros
function check_error($command, $description) {
    echo "<strong>🔍 Verificando: $description</strong><br>";
    $output = shell_exec("$command 2>&1");
    if (strpos($output, 'Error') !== false || strpos($output, 'error') !== false) {
        echo "<span style='color: red;'>❌ ERRO:</span><br>";
    } else {
        echo "<span style='color: green;'>✅ OK</span><br>";
    }
    echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px;'>$output</pre>";
    echo "<br>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Elegance Joias - Pós-Deploy</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 20px auto; background: #f9f9f9; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        pre { overflow-x: auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 Elegance Joias - Pós-Deploy</h1>

    <?php

    echo "<h2>Executando tarefas de deployment...</h2>";
    echo "<hr>";

    // 0. Remover diretórios de cache manualmente
    echo "<strong>🔥 0. Removendo cache manualmente (força máxima)</strong><br>";
    @shell_exec("rm -rf bootstrap/cache/*");
    @shell_exec("rm -rf storage/framework/cache/*");
    echo "<span class='success'>✅ Cache removido</span><br><br>";

    // 1. Limpar cache
    run_command("php artisan config:clear", "1. Limpando cache de configuração");
    run_command("php artisan cache:clear", "2. Limpando cache geral");    // 2. Verificar .env
    echo "<strong>🔍 Verificando configuração de banco de dados</strong><br>";
    if (file_exists('.env')) {
        echo "<span class='success'>✅ Arquivo .env encontrado</span><br>";
        // Ler variáveis sem exibir senhas
        $env = file_get_contents('.env');
        if (strpos($env, 'DB_CONNECTION=mysql') !== false) {
            echo "<span class='success'>✅ DB_CONNECTION está setado para MySQL</span><br>";
        } else {
            echo "<span class='error'>❌ DB_CONNECTION não está como MySQL</span><br>";
        }
    } else {
        echo "<span class='error'>❌ Arquivo .env NÃO encontrado</span><br>";
    }
    echo "<br>";

    // 3. Testar conexão com banco de dados
    echo "<strong>🔗 Testando conexão com banco de dados MySQL</strong><br>";
    $test_db = shell_exec("php artisan db:show 2>&1");
    if (strpos($test_db, 'Error') !== false || strpos($test_db, 'error') !== false) {
        echo "<span class='error'>❌ ERRO na conexão:</span><br>";
        echo "<pre style='background: #ffe0e0; padding: 10px; border-radius: 5px;'>$test_db</pre>";
    } else {
        echo "<span class='success'>✅ Conexão OK!</span><br>";
        echo "<pre style='background: #e0ffe0; padding: 10px; border-radius: 5px;'>$test_db</pre>";
    }
    echo "<br>";

    // 4. Executar migrations
    echo "<strong>📊 Executando migrations (criando/atualizando tabelas)</strong><br>";
    run_command("php artisan migrate --force", "Migrando banco de dados");

    // 5. Limpar cache novamente
    run_command("php artisan config:cache", "Cacheando configuração para produção");
    run_command("php artisan route:cache", "Cacheando rotas");
    run_command("php artisan view:cache", "Cacheando views");

    // 6. Ajustar permissões
    echo "<strong>🔐 Ajustando permissões de arquivos</strong><br>";
    run_command("chmod -R 775 storage bootstrap/cache", "Permissões de storage e cache");

    // 7. Verificação final
    echo "<hr>";
    echo "<h2>✅ Resumo</h2>";
    echo "Todas as tarefas foram executadas!<br>";
    echo "Se não houve erros acima, seu site está pronto em produção.<br>";
    echo "<br>";
    echo "<strong>Próximo passo:</strong> Acesse seu site: <a href='https://" . $_SERVER['HTTP_HOST'] . "' target='_blank'>https://" . $_SERVER['HTTP_HOST'] . "</a>";

    ?>
</div>
</body>
</html>
