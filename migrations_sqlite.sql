-- Execute este arquivo SQL para aplicar as migrations no SQLite

-- Tabela de cupons
CREATE TABLE IF NOT EXISTS coupons (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  code TEXT NOT NULL UNIQUE,
  type TEXT DEFAULT 'percentage' CHECK(type IN ('percentage', 'fixed')),
  value REAL NOT NULL,
  min_purchase REAL,
  usage_limit INTEGER,
  usage_count INTEGER DEFAULT 0,
  valid_from DATETIME,
  valid_until DATETIME,
  active INTEGER DEFAULT 1,
  created_at DATETIME,
  updated_at DATETIME
);

-- Tabela de reviews
CREATE TABLE IF NOT EXISTS reviews (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  product_id INTEGER NOT NULL,
  order_id INTEGER,
  rating INTEGER DEFAULT 5,
  comment TEXT NOT NULL,
  approved INTEGER DEFAULT 0,
  created_at DATETIME,
  updated_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
  UNIQUE(user_id, product_id)
);

-- Adicionar coluna min_stock na tabela products se não existir
ALTER TABLE products ADD COLUMN min_stock INTEGER DEFAULT 5;

-- Adicionar campos na tabela orders se não existirem
ALTER TABLE orders ADD COLUMN status TEXT DEFAULT 'pending' CHECK(status IN ('pending', 'processing', 'completed', 'cancelled'));
ALTER TABLE orders ADD COLUMN shipping_address TEXT;
ALTER TABLE orders ADD COLUMN postal_code TEXT;
ALTER TABLE orders ADD COLUMN coupon_code TEXT;
ALTER TABLE orders ADD COLUMN discount_amount REAL DEFAULT 0.00;

-- Criar índice na tabela reviews
CREATE UNIQUE INDEX IF NOT EXISTS idx_reviews_user_product ON reviews(user_id, product_id);
