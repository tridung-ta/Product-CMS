<?php

namespace App\Security;

use App\Http\HttpException;
use App\Http\Request;

final class Csrf
{
    public static function token(): string
    {
        if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function validate(mixed $token): bool
    {
        $expected = $_SESSION['csrf_token'] ?? null;

        return is_string($token) && is_string($expected)
            && $expected !== '' && hash_equals($expected, $token);
    }

    public static function requirePost(): void
    {
        Request::requireMethods(['POST']);

        if (!self::validate($_POST['csrf_token'] ?? null)) {
            throw new HttpException(403, 'Phiên biểu mẫu không hợp lệ hoặc đã hết hạn. Vui lòng tải lại trang và thử lại.');
        }
    }
}
