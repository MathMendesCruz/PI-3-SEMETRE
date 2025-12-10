<?php
/**
 * Script de Diagnóstico
 * Verifica a configuração do banco de dados
 * 
 * Acesse: https://seu-dominio.com.br/diagnostico.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Diagnóstico - Elegance Joias</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 20px auto; background: #f9f9f9; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .ok { color: green; font-weight: bold; }
        .erro { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 Diagnóstico - Elegance Joias</h1>
    
    <?php
    
    // 1. Verificar .env
    echo "<h2>1. Arquivo .env</h2>";
    if (file_exists('.env')) {
        echo "<span class='ok'>✅ .env encontrado</span><br>";
        $env = file_get_contents('.env');
        
        // Verificar variáveis críticas
        preg_match('/DB_CONNECTION=(\S+)/', $env, $conn);
        preg_match('/DB_DATABASE=(\S+)/', $env, $db);
        preg_match('/DB_USERNAME=(\S+)/', $env, $user);
        preg_match('/DB_HOST=(\S+)/', $env, $host);
        
        echo "DB_CONNECTION: <strong>" . ($conn[1] ?? 'NÃO ENCONTRADO') . "</strong><br>";
        echo "DB_HOST: <strong>" . ($host[1] ?? 'NÃO ENCONTRADO') . "</strong><br>";
        echo "DB_DATABASE: <strong>" . ($db[1] ?? 'NÃO ENCONTRADO') . "</strong><br>";
        echo "DB_USERNAME: <strong>" . ($user[1] ?? 'NÃO ENCONTRADO') . "</strong><br>";
        
        if (isset($conn[1]) && $conn[1] === 'mysql') {
            echo "<span class='ok'>✅ Configurado para MySQL</span><br>";
        } else {
            echo "<span class='erro'>❌ NÃO está configurado para MySQL!</span><br>";
        }
    } else {
        echo "<span class='erro'>❌ .env NÃO encontrado!</span><br>";
    }
    
    echo "<br><h2>2. Configuração Carregada pelo Laravel</h2>";
    
    // Carregar configuração do Laravel
    try {
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        $app->make('config');
        
        $db_connection = config('database.default');
        $db_config = config('database.connections.' . $db_connection);
        
        echo "Banco padrão: <strong>$db_connection</strong><br>";
        
        if ($db_connection === 'mysql') {
            echo "<span class='ok'>✅ Laravel está usando MySQL</span><br>";
            echo "<br>Detalhes:<br>";
            echo "Host: " . ($db_config['host'] ?? 'N/A') . "<br>";
            echo "Database: " . ($db_config['database'] ?? 'N/A') . "<br>";
            echo "Username: " . ($db_config['username'] ?? 'N/A') . "<br>";
        } else if ($db_connection === 'sqlite') {
            echo "<span class='erro'>❌ Laravel está usando SQLite!</span><br>";
            echo "<br><strong>SOLUÇÃO:</strong><br>";
            echo "1. Acesse: <a href='limpar-cache.php?chave=elegance2025'>limpar-cache.php?chave=elegance2025</a><br>";
            echo "2. Aguarde a página carregar completamente<br>";
            echo "3. Volte para cá e recarregue (F5)<br>";
        }
    } catch (Exception $e) {
        echo "<span class='warning'>⚠️ Erro ao carregar Laravel: " . $e->getMessage() . "</span><br>";
    }
    
    echo "<br><h2>3. Conexão com Banco de Dados</h2>";
    
    try {
        // Tentar conectar ao banco
        $env = file_get_contents('.env');
        preg_match('/DB_HOST=(\S+)/', $env, $m_host);
        preg_match('/DB_DATABASE=(\S+)/', $env, $m_db);
        preg_match('/DB_USERNAME=(\S+)/', $env, $m_user);
        preg_match('/DB_PASSWORD=(.+)/', $env, $m_pass);
        
        $host = $m_host[1] ?? 'localhost';
        $database = $m_db[1] ?? '';
        $username = $m_user[1] ?? '';
        $password = trim($m_pass[1] ?? '');
        
        $conexao = new mysqli($host, $username, $password, $database);
        
        if ($conexao->connect_error) {
            echo "<span class='erro'>❌ Erro de conexão: " . $conexao->connect_error . "</span><br>";
        } else {
            echo "<span class='ok'>✅ Conexão MySQL OK!</span><br>";
            echo "Host: $host<br>";
            echo "Banco: $database<br>";
            
            // Verificar tabelas
            $result = $conexao->query("SHOW TABLES");
            $count = $result->num_rows;
            echo "Tabelas no banco: <strong>$count</strong><br>";
            
            if ($count > 0) {
                echo "Tabelas: ";
                while ($row = $result->fetch_row()) {
                    echo $row[0] . ", ";
                }
                echo "<br>";
            }
            
            $conexao->close();
        }
    } catch (Exception $e) {
        echo "<span class='erro'>❌ Erro ao testar conexão: " . $e->getMessage() . "</span><br>";
    }
    
    echo "<br><hr>";
    echo "<h2>4. Próximos Passos</h2>";
    
    echo "<ol>";
    echo "<li>Se Laravel ainda está usando SQLite:<br>";
    echo "   → Clique em <a href='limpar-cache.php?chave=elegance2025'><strong>limpar-cache.php</strong></a><br>";
    echo "   → Aguarde completar<br>";
    echo "   → Volte aqui e recarregue";
    echo "</li>";
    echo "<li>Se a conexão MySQL está OK:<br>";
    echo "   → Acesse seu site: <a href='https://" . $_SERVER['HTTP_HOST'] . "' target='_blank'>https://" . $_SERVER['HTTP_HOST'] . "</a>";
    echo "</li>";
    echo "<li>Se ainda houver erro:<br>";
    echo "   → Verifique as credenciais MySQL no Painel Hostinger<br>";
    echo "   → Confirme que o banco existe<br>";
    echo "   → Confirme que o usuário tem permissões";
    echo "</li>";
    echo "</ol>";
    
    ?>
</div>
</body>
</html>
