<?php

namespace App\Models;

use App\Database\Model;

class User extends Model
{
    public function findByUsername(string $username): ?array
    {
        return $this->executeQuery(
            'SELECT id, username, password, created_at FROM users WHERE username = :username LIMIT 1',
            [':username' => $username]
        )->fetch() ?: null;
    }
}
