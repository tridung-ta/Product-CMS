<?php

namespace App\Http;

final class Request
{
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function requireMethods(array $methods): void
    {
        if (!in_array(self::method(), $methods, true)) {
            header('Allow: ' . implode(', ', $methods));
            throw new HttpException(405, 'Phương thức yêu cầu không được hỗ trợ.');
        }
    }

    public static function queryString(string $name, string $default = ''): string
    {
        return self::stringValue($_GET, $name, $default);
    }

    public static function postString(string $name, string $default = ''): string
    {
        return self::stringValue($_POST, $name, $default);
    }

    public static function queryInt(string $name, int $default = 0): int
    {
        return self::integer(self::queryString($name), $default);
    }

    public static function postInt(string $name, int $default = 0): int
    {
        return self::integer(self::postString($name), $default);
    }

    private static function stringValue(array $source, string $name, string $default): string
    {
        if (!array_key_exists($name, $source)) {
            return $default;
        }
        if (!is_string($source[$name])) {
            throw new HttpException(400, 'Tham số yêu cầu không hợp lệ.');
        }

        return $source[$name];
    }

    private static function integer(string $value, int $default): int
    {
        $parsed = filter_var($value, FILTER_VALIDATE_INT);
        return $parsed === false ? $default : $parsed;
    }
}
