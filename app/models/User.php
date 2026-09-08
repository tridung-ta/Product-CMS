<?php

namespace App\Models;

use Config\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'username' => $username
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }
}