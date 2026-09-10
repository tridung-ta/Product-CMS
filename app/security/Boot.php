<?php

namespace App\Security;

use App\Http\HttpException;
use Throwable;

final class Boot
{
    public static function run(callable $dispatch): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: same-origin');

        try {
            $dispatch();
        } catch (HttpException $e) {
            http_response_code($e->status);
            echo htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        } catch (Throwable $e) {
            error_log((string) $e);
            http_response_code(500);
            echo 'Không thể xử lý yêu cầu lúc này. Vui lòng thử lại sau.';
        }
    }

    public static function session(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        session_set_cookie_params([
            'httponly' => true,
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Lax',
            'path' => '/',
        ]);
        session_start();
    }

    public static function logout(): void
    {
        self::session();
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'],
        ]);
        session_destroy();
    }
}
