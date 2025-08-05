<?php

$pdo = require "../../connection.php";

try {
    $sql = "DROP TABLE IF EXISTS products";

    $pdo->exec($sql);

    echo "Table dropped successfully" . "\n";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    die();
}