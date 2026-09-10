<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// Read from stdin so passwords need not appear in shell arguments or history.
$password = rtrim(stream_get_contents(STDIN), "\r\n");
if ($password === '') {
    fwrite(STDERR, "Cần cung cấp mật khẩu qua stdin.\n");
    exit(1);
}
echo password_hash($password, PASSWORD_DEFAULT) . PHP_EOL;
