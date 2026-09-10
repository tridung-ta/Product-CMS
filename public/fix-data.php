<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

if (!in_array('--apply', $argv, true)) {
    echo "Tiện ích này sửa mô tả sản phẩm ID 1 và 2. Chạy với --apply để thực hiện.\n";
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;

$database = new Database();
$db = $database->connect();

$sql = "UPDATE products
        SET description = CASE id
            WHEN 1 THEN 'Điện thoại Apple'
            WHEN 2 THEN 'Điện thoại Samsung'
            ELSE description
        END
        WHERE id IN (1, 2)";

$db->exec($sql);

echo "Đã sửa dữ liệu tiếng Việt thành công!";
