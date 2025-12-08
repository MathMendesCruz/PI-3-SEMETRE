<?php

// Conectar ao banco SQLite
$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');

$products = [
    // ===== FEMININO - ANÉIS IMPORTADOS =====
    [
        'name' => 'Anel Ouro com Safira Azul',
        'description' => 'Anel refinado em ouro amarelo 18 quilates com safira azul natural. Design elegante com acabamento brilhante e polido.',
        'price' => 2100.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'anel-ouro-safira-small.webp',
        'stock' => 6,
    ],
    [
        'name' => 'Anel Ouro Rosa Delicado',
        'description' => 'Anel delicado em ouro rose 18 quilates com design sofisticado. Perfeito para uso diário ou ocasiões especiais.',
        'price' => 1800.00,
        'category' => 'feminino',
        'brand' => 'GUCCI',
        'image' => 'anel-ouro-rosa-delicado-small.webp',
        'stock' => 8,
    ],
    [
        'name' => 'Anel Diamante Noivado Premium',
        'description' => 'Clássico anel de noivado em ouro branco 18K com diamante solitário certificado de 1.5 quilates.',
        'price' => 5000.00,
        'category' => 'feminino',
        'brand' => 'PRADA',
        'image' => 'anel-diamante-noivado-small.webp',
        'stock' => 3,
    ],
    [
        'name' => 'Anel Esmeralda com Halo',
        'description' => 'Anel sofisticado com esmeralda natural e diamantes em halo. Ouro branco 18K, fechamento seguro tipo mola.',
        'price' => 3200.00,
        'category' => 'feminino',
        'brand' => 'CALVIN KLEIN',
        'image' => 'anel-esmeralda-halo-small.webp',
        'stock' => 4,
    ],
    [
        'name' => 'Anel Ouro Clássico Feminino',
        'description' => 'Anel clássico em ouro amarelo 18 quilates com design simples e elegante. Tamanho ajustável, acabamento polido.',
        'price' => 1600.00,
        'category' => 'feminino',
        'brand' => 'ZARA',
        'image' => 'anel-ouro-classico-small.webp',
        'stock' => 7,
    ],
    [
        'name' => 'Anel Ouro Fino Minimalista',
        'description' => 'Anel fino e delicado em ouro amarelo 18K com design minimalista contemporâneo. Perfeito para criar looks sofisticados.',
        'price' => 1300.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'anel-ouro-fino-small.webp',
        'stock' => 9,
    ],
    [
        'name' => 'Anel Ouro Minimalista Feminino',
        'description' => 'Anel simples e sofisticado em ouro rose 18 quilates. Design moderno para complementar qualquer look.',
        'price' => 1250.00,
        'category' => 'feminino',
        'brand' => 'GUCCI',
        'image' => 'anel-ouro-minimalista-small.webp',
        'stock' => 8,
    ],
    [
        'name' => 'Anel Ouro Liso Premium',
        'description' => 'Anel liso em ouro branco 18K com acabamento espelhado. Design versátil para uso diário ou ocasiões especiais.',
        'price' => 1450.00,
        'category' => 'feminino',
        'brand' => 'PRADA',
        'image' => 'anel-ouro-liso-small.webp',
        'stock' => 5,
    ],
    // ===== FEMININO - COLARES IMPORTADOS =====
    [
        'name' => 'Colar Corrente Fina Ouro',
        'description' => 'Colar elegante com corrente fina em ouro amarelo 18K. Design minimalista, comprimento: 45cm, perfeito para uso diário.',
        'price' => 1200.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'colar-corrente-fina-small.webp',
        'stock' => 6,
    ],
    [
        'name' => 'Colar Pingente Pantera Ouro',
        'description' => 'Colar refinado com pingente em formato de pantera com olhos em diamante. Ouro amarelo 18K, comprimento: 45cm.',
        'price' => 2200.00,
        'category' => 'feminino',
        'brand' => 'GUCCI',
        'image' => 'colar-pingente-pantera-small.webp',
        'stock' => 5,
    ],
    [
        'name' => 'Colar Safira em Ouro Branco',
        'description' => 'Colar elegante em ouro branco 18K com pingente de safira azul. Comprimento ajustável, ideal para ocasiões especiais.',
        'price' => 2200.00,
        'category' => 'feminino',
        'brand' => 'PRADA',
        'image' => 'colar-safira-branco-small.webp',
        'stock' => 4,
    ],
    [
        'name' => 'Colar Ouro Simples Feminino',
        'description' => 'Colar minimalista em ouro amarelo 18K com design sofisticado. Comprimento: 50cm, acabamento polido.',
        'price' => 1400.00,
        'category' => 'feminino',
        'brand' => 'CALVIN KLEIN',
        'image' => 'colar-ouro-simples-small.webp',
        'stock' => 7,
    ],
    [
        'name' => 'Colar Corrente Grumet Ouro',
        'description' => 'Colar clássico em ouro amarelo 18 quilates com corrente grumet forte. Comprimento: 50cm, peso: 8g.',
        'price' => 1600.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'colar-corrente-grumet-small.webp',
        'stock' => 5,
    ],
    [
        'name' => 'Colar Ouro Fino Premium',
        'description' => 'Colar fino em ouro amarelo 18K com design delicado. Perfeito para complementar looks sofisticados, comprimento: 48cm.',
        'price' => 1350.00,
        'category' => 'feminino',
        'brand' => 'GUCCI',
        'image' => 'colar-ouro-fino-small.webp',
        'stock' => 6,
    ],
    [
        'name' => 'Colar Ouro Rose Feminino',
        'description' => 'Colar em ouro rose 18 quilates com design elegante. Comprimento: 50cm, ideal para uso diário ou ocasiões.',
        'price' => 1500.00,
        'category' => 'feminino',
        'brand' => 'PRADA',
        'image' => 'colar-ouro-rose-small.webp',
        'stock' => 5,
    ],
    [
        'name' => 'Colar Corrente Forte Ouro',
        'description' => 'Colar em ouro amarelo 18 quilates com corrente forte e durável. Comprimento: 55cm, peso: 8g.',
        'price' => 1700.00,
        'category' => 'feminino',
        'brand' => 'CALVIN KLEIN',
        'image' => 'colar-corrente-forte-small.webp',
        'stock' => 4,
    ],
    [
        'name' => 'Colar Ouro Delicado 18K',
        'description' => 'Colar delicado em ouro branco 18K com acabamento polido. Design versátil para qualquer ocasião, comprimento: 45cm.',
        'price' => 1300.00,
        'category' => 'feminino',
        'brand' => 'ZARA',
        'image' => 'colar-ouro-delicado-small.webp',
        'stock' => 7,
    ],
    [
        'name' => 'Colar Safira Rosa Ouro',
        'description' => 'Colar sofisticado em ouro amarelo 18K com pingente de safira rosa. Comprimento ajustável: 48cm.',
        'price' => 2000.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'colar-safira-rosa-small.webp',
        'stock' => 3,
    ],
    [
        'name' => 'Colar Ouro Liso Feminino',
        'description' => 'Colar liso em ouro rose 18K com design minimalista. Comprimento: 50cm, acabamento espelhado.',
        'price' => 1400.00,
        'category' => 'feminino',
        'brand' => 'GUCCI',
        'image' => 'colar-ouro-liso-small.webp',
        'stock' => 6,
    ],
    [
        'name' => 'Colar Pingente Pequeno Ouro',
        'description' => 'Colar delicado com pequeno pingente em ouro amarelo 18K. Comprimento: 45cm, acabamento fino e elegante.',
        'price' => 1200.00,
        'category' => 'feminino',
        'brand' => 'PRADA',
        'image' => 'colar-pingente-pequeno-small.webp',
        'stock' => 8,
    ],
    [
        'name' => 'Colar Corrente Dupla Ouro',
        'description' => 'Colar com corrente dupla em ouro branco 18K. Comprimento: 50cm, design moderno e sofisticado.',
        'price' => 1800.00,
        'category' => 'feminino',
        'brand' => 'CALVIN KLEIN',
        'image' => 'colar-corrente-dupla-small.webp',
        'stock' => 4,
    ],
    [
        'name' => 'Colar Ouro Comprido 18K',
        'description' => 'Colar comprido em ouro amarelo 18K com design elegante. Comprimento: 60cm, ideal para looks alongados.',
        'price' => 1600.00,
        'category' => 'feminino',
        'brand' => 'ZARA',
        'image' => 'colar-ouro-comprido-small.webp',
        'stock' => 5,
    ],
    [
        'name' => 'Colar Pingente Quadrado Ouro',
        'description' => 'Colar sofisticado com pingente quadrado em ouro rose 18K. Comprimento: 48cm, design geométrico.',
        'price' => 1500.00,
        'category' => 'feminino',
        'brand' => 'VERSACE',
        'image' => 'colar-pingente-quadrado-small.webp',
        'stock' => 5,
    ],
    // ===== MASCULINO - RELÓGIOS =====
    [
        'name' => 'Relógio Pulso em Ouro 18K',
        'description' => 'Relógio de pulso elegante em ouro 18 quilates com movimento automático. Caixa: 42mm, impermeável.',
        'price' => 4500.00,
        'category' => 'masculino',
        'brand' => 'VERSACE',
        'image' => 'relogio1.png',
        'stock' => 2,
    ],
    [
        'name' => 'Relógio Ouro Branco Premium',
        'description' => 'Relógio de luxo em ouro branco 18K com movimento suíço. Caixa: 40mm, cronógrafo.',
        'price' => 5200.00,
        'category' => 'masculino',
        'brand' => 'GUCCI',
        'image' => 'relogio1.png',
        'stock' => 1,
    ],
    [
        'name' => 'Relógio Ouro Rose Clássico',
        'description' => 'Relógio clássico em ouro rose 18 quilates com design timeless. Caixa: 38mm, movimento automático suíço.',
        'price' => 4800.00,
        'category' => 'masculino',
        'brand' => 'PRADA',
        'image' => 'relogio1.png',
        'stock' => 2,
    ],
    [
        'name' => 'Relógio Ouro Amarelo Esportivo',
        'description' => 'Relógio esportivo em ouro amarelo 18K com movimento resistente. Caixa: 44mm, à prova d\'água até 100m.',
        'price' => 4200.00,
        'category' => 'masculino',
        'brand' => 'CALVIN KLEIN',
        'image' => 'relogio1.png',
        'stock' => 3,
    ],
    [
        'name' => 'Relógio Ouro 18K com Diamante',
        'description' => 'Relógio luxuoso em ouro 18 quilates com incrustações de diamantes. Caixa: 36mm, movimento automático.',
        'price' => 5800.00,
        'category' => 'masculino',
        'brand' => 'ZARA',
        'image' => 'relogio1.png',
        'stock' => 1,
    ],
];

// Deletar produtos antigos (opcionalmente)
$db->exec("DELETE FROM products WHERE image LIKE '%small.webp%' OR category IN ('feminino', 'masculino')");

// Preparar a query de inserção
$stmt = $db->prepare("
    INSERT INTO products (name, description, price, category, brand, image, stock, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))
");

$inserted = 0;
foreach ($products as $product) {
    try {
        $stmt->execute([
            $product['name'],
            $product['description'],
            $product['price'],
            $product['category'],
            $product['brand'],
            $product['image'],
            $product['stock'],
        ]);
        $inserted++;
    } catch (Exception $e) {
        echo "Erro ao inserir {$product['name']}: " . $e->getMessage() . "\n";
    }
}

echo "✅ {$inserted} produtos inseridos com sucesso!\n";
?>
