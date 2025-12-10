<?php
/**
 * Script Nuclear de Fix
 * Remove TUDO de cache e força Laravel a ler o .env novamente
 *
 * Acesse: https://seu-dominio.com.br/fix.php
 */

echo "🔥 NUCLEAR FIX - Removendo todos os caches\n\n";

// 1. Remover todos os arquivos de cache
$paths = [
    'bootstrap/cache',
    'storage/framework/cache',
    'storage/framework/views',
];

foreach ($paths as $path) {
    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filepath = $path . '/' . $file;
                if (is_file($filepath)) {
                    @unlink($filepath);
                    echo "✅ Removido: $filepath\n";
                }
            }
        }
    }
}

echo "\n✅ Cache removido!\n";
echo "Aguarde redirecionamento em 3 segundos...\n";
echo "<meta http-equiv='refresh' content='3;url=/'>";

// Force garbage collection
gc_collect_cycles();
?>
