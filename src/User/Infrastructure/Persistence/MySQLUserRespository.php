<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Persistence;

use Src\User\Domain\Model\User;
use Src\Shader\Infrastructure\Database\Conexion;
use Src\User\Domain\Repository\UserRepositoryInterface;

class MySQLUserRespository implements UserRepositoryInterface
{
    public function getAll(array $params = []): array
    {
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Construir la consulta base
        $query = 'SELECT id, email, password FROM users';

        // Agregar filtros si se proporcionan
        $filters = $this->buildFilters($params);
        if (!empty($filters['conditions'])) {
            $query .= ' WHERE ' . implode(' AND ', $filters['conditions']);
        }

        // Preparar y ejecutar la consulta
        $statement = $pdo->prepare($query);
        foreach ($filters['bindings'] as $placeholder => $value) {
            $statement->bindValue($placeholder, $value);
        }
        $statement->execute();
        $results = $statement->fetchAll();

        // Mapear los resultados a objetos User
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
        $conexion = new Conexion();
        $pdo = $conexion->getConexion();

        // Consulta para obtener el usuario por ID
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
        // Implementación para registrar un usuario
    }

    public function updateEmail(int $userId, string $email): void
    {
        // Implementación para actualizar el email de un usuario
    }

    public function updatePassword(int $userId, string $password): void
    {
        // Implementación para actualizar la contraseña de un usuario
    }

    public function delete(int $userId): void
    {
        // Implementación para eliminar un usuario
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
