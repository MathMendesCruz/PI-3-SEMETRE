<?php
// Script para executar migrations
// Acesse: https://elegancejoias.store/migrate.php

echo "Executando migrations...\n\n";
$output = shell_exec("php artisan migrate --force 2>&1");
echo "<pre>$output</pre>";
echo "\n\nPronto! <a href='/'>Voltar ao site</a>";
?>
