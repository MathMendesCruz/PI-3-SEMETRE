<?php
/**
 * Script Simplificado - Apenas Criar Tabelas
 * Acesse: https://elegancejoias.store/criar-tabelas.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Criar Tabelas - MySQL</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #00ff00; }
        .ok { color: #00ff00; }
        .erro { color: #ff0000; }
        pre { background: #000; padding: 10px; border: 1px solid #333; }
    </style>
</head>
<body>
<h1>🗄️ Criando Tabelas no MySQL</h1>

<?php
echo "<h2>Passo 1: Executando php artisan migrate --force</h2>";
echo "<pre>";

$output = shell_exec("php artisan migrate --force 2>&1");
echo $output;

echo "</pre>";

if (strpos($output, 'Migration table created successfully') !== false || 
    strpos($output, 'Migrating') !== false || 
    strpos($output, 'Nothing to migrate') !== false) {
    echo "<p class='ok'>✅ Migrations executadas com sucesso!</p>";
} else {
    echo "<p class='erro'>❌ Erro ao executar migrations</p>";
    echo "<p>Tentando criar manualmente...</p>";
}

echo "<h2>Passo 2: Verificando tabelas criadas</h2>";
echo "<pre>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    
    $pdo = DB::connection()->getPdo();
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tabelas criadas: " . count($tables) . "\n\n";
    foreach ($tables as $table) {
        echo "✅ $table\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}

echo "</pre>";

echo "<h2>✅ Pronto!</h2>";
echo "<p>Acesse seu site: <a href='/' style='color: #00ff00;'>https://elegancejoias.store/</a></p>";
?>
</body>
</html>
