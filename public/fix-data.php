<?php

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