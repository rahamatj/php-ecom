<?php
require __DIR__ . "/../../../functions.php";
$pdo = require __DIR__ . "/../../../connection.php";

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([':id' => $id])) {

            header("Location: " . route("ecom/admin/categories/all.php"));
        } else {
            echo "Failed to delete record.";
        }
    }
} catch (PDOException $e) {
    echo "Something went wrong: " . $e->getMessage() . "\n";
    die();
}
