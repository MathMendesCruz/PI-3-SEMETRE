<?php
/**
 * Script de Limpeza de Cache Extrema
 * Use se o post-deploy.php não resolver o problema
 *
 * Acesse: https://seu-dominio.com.br/limpar-cache.php?chave=elegance2025
 */

$chave = $_GET['chave'] ?? '';

if ($chave !== 'elegance2025') {
    http_response_code(403);
    die('❌ Chave inválida');
}

echo "🔥 LIMPEZA EXTREMA DE CACHE<br><br>";

// Remover arquivos de cache do Laravel
$diretorios = [
    'bootstrap/cache',
    'storage/framework/cache',
    'storage/framework/views',
];

foreach ($diretorios as $dir) {
    echo "Limpando: $dir<br>";
    if (is_dir($dir)) {
        $files = glob("$dir/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        echo "  ✅ OK<br>";
    } else {
        echo "  ⚠️ Diretório não encontrado<br>";
    }
}

echo "<br>✅ Cache limpo!<br>";
echo "Agora acesse: <a href='https://" . $_SERVER['HTTP_HOST'] . "'>https://" . $_SERVER['HTTP_HOST'] . "</a>";

// Executar artisan para recriar cache com novo .env
echo "<hr>";
echo "Recriando cache com novas configurações...<br>";
$output = shell_exec("php artisan config:cache 2>&1");
echo "<pre>$output</pre>";

echo "<br>✅ DONE!";
?>
