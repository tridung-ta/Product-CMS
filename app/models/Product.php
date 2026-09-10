<?php

namespace App\Models;

use App\Database\Model;
use InvalidArgumentException;

class Product extends Model
{
    private const COLUMNS = 'id, name, price, quantity, description, created_at, updated_at';

    public function getAll(): array
    {
        return $this->executeQuery(
            'SELECT ' . self::COLUMNS . ' FROM products ORDER BY id DESC'
        )->fetchAll();
    }

    public function insert(
        string $name,
        string|float|int $price,
        int $quantity,
        string $description
    ): bool {
        $this->executeQuery(
            'INSERT INTO products (name, price, quantity, description)
             VALUES (:name, :price, :quantity, :description)',
            [
                ':name' => $name,
                ':price' => (string) $price,
                ':quantity' => $quantity,
                ':description' => $description,
            ]
        );

        return true;
    }

    public function getSummary(): array
    {
        return $this->executeQuery(
            'SELECT COUNT(*) AS total_products,
                    COALESCE(SUM(quantity), 0) AS total_quantity,
                    COALESCE(SUM(price * quantity), 0) AS total_value
             FROM products'
        )->fetch() ?: [
            'total_products' => 0,
            'total_quantity' => 0,
            'total_value' => 0,
        ];
    }

    public function getById(int $id): ?array
    {
        return $this->executeQuery(
            'SELECT ' . self::COLUMNS . ' FROM products WHERE id = :id',
            [':id' => $id]
        )->fetch() ?: null;
    }

    public function update(
        int $id,
        string $name,
        string|float|int $price,
        int $quantity,
        string $description
    ): bool {
        $this->executeQuery(
            'UPDATE products
             SET name = :name, price = :price, quantity = :quantity, description = :description
             WHERE id = :id',
            [
                ':id' => $id,
                ':name' => $name,
                ':price' => (string) $price,
                ':quantity' => $quantity,
                ':description' => $description,
            ]
        );

        return true;
    }

    public function delete(int $id): bool
    {
        return $this->executeQuery(
            'DELETE FROM products WHERE id = :id',
            [':id' => $id]
        )->rowCount() > 0;
    }

    public function search(string $keyword): array
    {
        [$filter, $parameters] = $this->searchFilter($keyword);

        return $this->executeQuery(
            'SELECT ' . self::COLUMNS . ' FROM products' . $filter . ' ORDER BY id DESC',
            $parameters
        )->fetchAll();
    }

    public function getTotal(string $keyword = ''): int
    {
        [$filter, $parameters] = $this->searchFilter($keyword);

        return (int) $this->executeQuery(
            'SELECT COUNT(*) FROM products' . $filter,
            $parameters
        )->fetchColumn();
    }

    public function getPaginated(int $limit, int $offset, string $keyword = ''): array
    {
        if ($limit < 1 || $offset < 0) {
            throw new InvalidArgumentException('Pagination requires a positive limit and a non-negative offset.');
        }

        [$filter, $parameters] = $this->searchFilter($keyword);
        $parameters[':limit'] = $limit;
        $parameters[':offset'] = $offset;

        return $this->executeQuery(
            'SELECT ' . self::COLUMNS . ' FROM products' . $filter .
            ' ORDER BY id DESC LIMIT :limit OFFSET :offset',
            $parameters
        )->fetchAll();
    }

    private function searchFilter(string $keyword): array
    {
        if ($keyword === '') {
            return ['', []];
        }

        return [
            ' WHERE (name LIKE :name_keyword OR description LIKE :description_keyword)',
            [
                ':name_keyword' => '%' . $keyword . '%',
                ':description_keyword' => '%' . $keyword . '%',
            ],
        ];
    }
}
