<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;

try {
    $database = new Database();
    $pdo = $database->connect();

    echo "<h1>Kết nối MySQL thành công!</h1>";

    $stmt = $pdo->query("SELECT * FROM products");

    echo "<h2>Danh sách sản phẩm:</h2>";

    echo "<pre>";
    print_r($stmt->fetchAll());
    echo "</pre>";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}