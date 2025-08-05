<?php

$pdo = require '../../connection.php';

try {
    for ($i = 0; $i < 10; $i++) {
        $sql = 'INSERT INTO products (name, price, category_id, description, image, stock, is_active) VALUES (:name, :price, :category_id, :description, :image, :stock, :is_active)';

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name);

        $name = 'Category ' . ($i + 1);

        $stmt->execute([
            ":name" => "Product " . ($i + 1),
            ":price" => 100,
            ":category_id" => $i + 1,
            ":description" => "Description " . ($i + 1),
            ":image" => "https://placehold.co/300",
            ":stock" => 100,
            ":is_active" => 1
        ]);
    }

    echo "Product inserted successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
