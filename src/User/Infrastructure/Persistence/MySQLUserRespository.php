<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Persistence;

use PDO;
use Src\User\Domain\Model\User;
use Src\Shader\Infrastructure\Database\Conexion;
use Src\User\Domain\Repository\UserRepositoryInterface;

class MySQLUserRespository implements UserRepositoryInterface
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

        $query = 'SELECT id, email, password FROM users';

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

        $users = [];
        foreach ($results as $row) {
            $users[] = new User(
                id: $row['id'],
                email: $row['email'],
                password: $row['password']
            );
        }

        return $users;
    }

    public function getById(int $userId): ?User
    {
        $pdo = $this->pdo;
        $query = 'SELECT id, email, password FROM users WHERE id = :id';

        // Preparar y ejecutar la consulta
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        // Obtener el resultado
        $row = $statement->fetch();

        // Mapear el resultado a un objeto User o retornar null si no se encuentra el usuario
        if ($row) {
            return new User(
                id: $row['id'],
                email: $row['email'],
                password: $row['password']
            );
        }

        return null;
    }

    public function register(string $email, string $password): void
    {
        $pdo = $this->pdo;
        $query = 'INSERT INTO users (email, password) VALUES (:email, :password)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }

    public function updateEmail(int $userId, string $email): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
        $stmt->bindValue(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updatePassword(int $userId, string $password): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindValue(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete(int $userId): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindValue(':id', $userId, \PDO::PARAM_INT);
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
