<?php

$pdo = require "../../connection.php";

try {
    $sql = "CREATE TABLE IF NOT EXISTS products
            (id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            category_id INT NOT NULL,
            description TEXT,
            image VARCHAR(255) NULL,
            stock INT NOT NULL,
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $pdo->exec($sql);

    echo "Table created successfully" . "\n";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    die();
}