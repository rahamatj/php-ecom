<?php

$pdo = require '../../connection.php';

try {
    for ($i = 0; $i < 10; $i++) {
        $sql = 'INSERT INTO categories (name) VALUES (:name)';

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name);

        $name = 'Category ' . ($i + 1);

        $stmt->execute();
    }

    echo "Category inserted successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
