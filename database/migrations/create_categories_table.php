<?php

$pdo = require "../../connection.php";

try {
    $sql = "CREATE TABLE IF NOT EXISTS categories
            (id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $pdo->exec($sql);

    echo "Table created successfully" . "\n";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    die();
}