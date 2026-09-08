<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private string $host = '127.0.0.1';
    private string $dbName = 'product_cms';
    private string $username = 'root';
    private string $password = '123456';

    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";

            $pdo = new PDO($dsn, $this->username, $this->password);

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $pdo->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            return $pdo;

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}