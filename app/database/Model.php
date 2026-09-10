<?php

namespace App\Database;

use Config\Database;
use PDO;
use PDOStatement;

abstract class Model
{
    protected PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? (new Database())->connect();
    }

    protected function executeQuery(string $sql, array $parameters = []): PDOStatement
    {
        if ($parameters === []) {
            return $this->db->query($sql);
        }

        $statement = $this->db->prepare($sql);

        foreach ($parameters as $name => $value) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                $value === null => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
            $statement->bindValue($name, $value, $type);
        }

        $statement->execute();

        return $statement;
    }
}
