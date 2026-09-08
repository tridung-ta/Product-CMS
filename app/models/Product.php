<?php

namespace App\Models;

use Config\Database;
use PDO;

class Product
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM products ORDER BY id DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function insert(
        string $name,
        float $price,
        int $quantity,
        string $description
    ): bool {
        $sql = "INSERT INTO products
                (name, price, quantity, description)
                VALUES
                (:name, :price, :quantity, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':quantity' => $quantity,
            ':description' => $description
        ]);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM products WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function update(
        int $id,
        string $name,
        float $price,
        int $quantity,
        string $description
    ): bool {
        $sql = "UPDATE products
                SET name = :name,
                    price = :price,
                    quantity = :quantity,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':price' => $price,
            ':quantity' => $quantity,
            ':description' => $description
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
    public function search(string $keyword): array
{
    $sql = "SELECT * FROM products
            WHERE name LIKE :keyword
               OR description LIKE :keyword
            ORDER BY id DESC";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':keyword' => '%' . $keyword . '%'
    ]);

    return $stmt->fetchAll();
}

public function getTotal(string $keyword = ''): int
{
    if ($keyword !== '') {
        $sql = "SELECT COUNT(*) FROM products
                WHERE name LIKE :keyword
                   OR description LIKE :keyword";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);
    } else {
        $sql = "SELECT COUNT(*) FROM products";

        $stmt = $this->db->query($sql);
    }

    return (int) $stmt->fetchColumn();
}

public function getPaginated(
    int $limit,
    int $offset,
    string $keyword = ''
): array {
    if ($keyword !== '') {
        $sql = "SELECT * FROM products
                WHERE name LIKE :keyword
                   OR description LIKE :keyword
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':keyword',
            '%' . $keyword . '%',
            PDO::PARAM_STR
        );
    } else {
        $sql = "SELECT * FROM products
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll();
}

}