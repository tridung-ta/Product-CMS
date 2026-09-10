<?php

namespace Config;

use PDO;
use RuntimeException;

class Database
{
    private static ?PDO $connection = null;

    public function connect(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $localPath = __DIR__ . '/database.local.php';
        $local = is_file($localPath) ? require $localPath : [];

        if (!is_array($local)) {
            throw new RuntimeException('Local database configuration must return an array.');
        }

        $host = self::setting('DB_HOST', $local, 'host', '127.0.0.1');
        $port = self::setting('DB_PORT', $local, 'port', '3306');
        $database = self::setting('DB_NAME', $local, 'database', 'product_cms');
        $username = self::setting('DB_USER', $local, 'username', 'root');
        $password = self::setting('DB_PASSWORD', $local, 'password', '');

        self::$connection = new PDO(
            "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return self::$connection;
    }

    private static function setting(string $environment, array $local, string $key, string $default): string
    {
        $value = getenv($environment);

        return $value !== false ? $value : (string) ($local[$key] ?? $default);
    }
}
