CREATE DATABASE sistema_lanches;

USE sistema_lanches;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') NOT NULL
);
select * from users;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0 
);
SELECT * FROM PRODUCTS;
ALTER TABLE products ADD COLUMN quantity INT DEFAULT 0;


CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE
);

select * from sales;
SELECT * FROM CART;
ALTER TABLE sales
ADD COLUMN product_name VARCHAR(255);
SET SQL_SAFE_UPDATES = 0;

UPDATE sales s
JOIN products p ON s.product_id = p.id
SET s.product_name = p.name;
-- VER QUEM COMPROU E O QUE COMPROU
SELECT * FROM sales WHERE user_id = '7';

SELECT 
    s.id AS sale_id,
    s.user_id,
    p.id AS product_id,
    p.name AS product_name,
    s.quantity,
    s.sale_date
FROM 
    sales s
INNER JOIN 
    products p ON s.product_id = p.id
ORDER BY 
    s.sale_date DESC; 


CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Chave primária da tabela 'cart'
    user_id INT NOT NULL,                       -- Chave estrangeira para a tabela 'users'
    product_id INT NOT NULL,                    -- Chave estrangeira para a tabela 'products'
    quantity INT NOT NULL DEFAULT 1,            -- Quantidade de produtos no carrinho (default 1)
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP, -- Data em que o item foi adicionado ao carrinho
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,  -- Liga 'cart' a 'users'
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE -- Liga 'cart' a 'products'
);
SELECT 
    c.id AS cart_id,
    u.name AS user_name,
    p.name AS product_name,
    c.quantity,
    c.date_added
FROM 
    cart c
INNER JOIN 
    users u ON c.user_id = u.id
INNER JOIN 
    products p ON c.product_id = p.id
WHERE 
    c.user_id = 1;  -- Exibe itens no carrinho do usuário com id 1


-- Consultas de exemplo
SELECT * FROM users;
SELECT * FROM users WHERE id = 1;
SELECT * FROM products;

-- Consulta para exibir vendas
SELECT 
    u.name AS user_name,
    p.name AS product_name,
    s.quantity,
    s.sale_date
FROM sales s
INNER JOIN users u ON s.user_id = u.id
INNER JOIN products p ON s.product_id = p.id
ORDER BY s.sale_date DESC;