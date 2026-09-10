<?php

namespace App\Http;

final class Url
{
    public static function product(string $action = 'list', array $params = []): string
    {
        return self::admin(['module' => 'manage', 'entity' => 'product', 'action' => $action] + $params);
    }

    public static function login(): string
    {
        return self::admin(['module' => 'auth', 'action' => 'login']);
    }

    public static function logout(): string
    {
        return self::admin(['module' => 'auth', 'action' => 'logout']);
    }

    private static function admin(array $params): string
    {
        return '/admin.php?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }
}
