<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;

try {
    $database = new Database();
    $pdo = $database->connect();

    $pdo->query('SELECT 1');
    echo "Kết nối MySQL thành công!\n";

} catch (Exception $e) {
    fwrite(STDERR, "Không thể kết nối MySQL. Kiểm tra cấu hình database.\n");
    exit(1);
}
