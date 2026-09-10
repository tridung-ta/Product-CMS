<?php

// No AJAX actions are implemented yet; never silently return a blank success.
http_response_code(404);
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
echo json_encode(['error' => 'Không tìm thấy chức năng AJAX.'], JSON_UNESCAPED_UNICODE);
