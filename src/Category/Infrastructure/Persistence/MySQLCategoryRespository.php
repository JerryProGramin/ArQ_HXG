<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Persistence;

use PDO;
use Src\Category\Domain\Model\Category;
use Src\Shader\Infrastructure\Database\Conexion;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;

class MySQLCategoryRespository implements CategoryRepositoryInterface
{
    private PDO $pdo;
    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getConexion();
    }
    public function getAll(array $params = []): array
    {
        $pdo = $this->pdo;
        $query = 'SELECT id, name, description FROM categories';

        $filters = $this->buildFilters($params);
        if (!empty($filters['conditions'])) {
            $query .= ' WHERE ' . implode(' AND ', $filters['conditions']);
        }

        $statement = $pdo->prepare($query);
        foreach ($filters['bindings'] as $placeholder => $value) {
            $statement->bindValue($placeholder, $value);
        }
        $statement->execute();
        $results = $statement->fetchAll();

        $categories = [];
        foreach ($results as $row) {
            $categories[] = new Category(
                id: $row['id'],
                name: $row['name'],
                description: $row['description']
            );
        }

        return $categories;
    }

    public function getById(int $categoryId): ?Category
    {
        $pdo = $this->pdo;
        $query = 'SELECT id, name, description FROM categories WHERE id = :id';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $categoryId, \PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch();

        if ($row) {
            return new Category(
                id: $row['id'],
                name: $row['name'],
                description: $row['description']
            );
        }

        return null;
    }

    public function register(string $name, string $description): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (:name, :description)');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(int $categoryId, string $name, string $description): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE categories SET name = :name, description = :description WHERE id = :id');
        $stmt->bindValue(':id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->execute();
    }

    public function delete(int $categoryId): void
    {
        $pdo  = $this->pdo;
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->bindValue(':id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function buildFilters(array $params): array
    {
        $conditions = [];
        $bindings = [];
        $placeholderIndex = 1;

        foreach ($params as $key => $value) {
            // Definir los operadores permitidos y sus funciones
            $operator = '=';
            if (is_array($value)) {
                if (isset($value['operator']) && in_array($value['operator'], ['LIKE', '=', 'IN'])) {
                    $operator = $value['operator'];
                    $value = $value['value'];
                }
            }

            $placeholder = ':param' . $placeholderIndex++;
            switch ($operator) {
                case 'LIKE':
                    $conditions[] = "$key LIKE $placeholder";
                    $bindings[$placeholder] = "%$value%";
                    break;
                case 'IN':
                    $placeholders = implode(', ', array_fill(0, count($value), $placeholder));
                    $conditions[] = "$key IN ($placeholders)";
                    foreach ($value as $item) {
                        $bindings[$placeholder++] = $item;
                    }
                    break;
                case '=':
                default:
                    $conditions[] = "$key = $placeholder";
                    $bindings[$placeholder] = $value;
                    break;
            }
        }

        return ['conditions' => $conditions, 'bindings' => $bindings];
    }
}
