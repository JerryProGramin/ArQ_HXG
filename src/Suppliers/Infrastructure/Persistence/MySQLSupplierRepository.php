<?php 

declare(strict_types = 1);

namespace Src\Suppliers\Infrastructure\Persistence;

use PDO;
use Src\Shader\Infrastructure\Database\Conexion;
use Src\Suppliers\Domain\Model\Supplier;
use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;

class MySQLSupplierRepository implements SupplierRepositoryInterface
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
        $query = 'SELECT id, name, contact_info, phone, email, address, country FROM suppliers';
        
        $filters = $this->buildFilters($params);
        if (!empty($filters['conditions'])) {
            $query.= ' WHERE '. implode(' AND ', $filters['conditions']);
        }
        $statement = $pdo->prepare($query);
        foreach ($filters['bindings'] as $placeholder => $value) {
            $statement->bindValue($placeholder, $value);
        }
        $statement->execute();
        $results = $statement->fetchAll();
        
        $suppliers = [];
        foreach ($results as $row) {
            $suppliers[] = new Supplier(
                id: $row['id'],
                name: $row['name'],
                contactInfo: $row['contact_info'],
                phone: $row['phone'],
                email: $row['email'],
                address: $row['address'],
                country: $row['country']
            );
        }
        return $suppliers;
    }

    public function getById(int $id):?Supplier
    {
        $pdo = $this->pdo;
        $query = $pdo->prepare('SELECT id, name, contact_info, phone, email, address, country FROM suppliers WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch();
        
        if ($row) {
            return new Supplier(
                id: $row['id'],
                name: $row['name'],
                contactInfo: $row['contact_info'],
                phone: $row['phone'],
                email: $row['email'],
                address: $row['address'],
                country: $row['country']
            );
        } 
        return null;
    }

    public function register(string $name, string $contactInfo, string $phone, string $email, string $address, string $country): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('INSERT INTO suppliers (name, contact_info, phone, email, address, country) VALUES (:name, :contact_info, :phone, :email, :address, :country)');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':contact_info', $contactInfo, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(int $supplierId, string $name, string $contactInfo, string $phone, string $email, string $address, string $country): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE suppliers SET name = :name, contact_info = :contact_info, phone = :phone, email = :email, address = :address, country = :country WHERE id = :id');
        $stmt->bindValue(':id', $supplierId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':contact_info', $contactInfo, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete(int $supplierId): void
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('DELETE FROM suppliers WHERE id = :id');
        $stmt->bindValue(':id', $supplierId, PDO::PARAM_INT);
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
                    $placeholders = [];
                    foreach ($value as $item) {
                        $ph = ':param' . $placeholderIndex++;
                        $placeholders[] = $ph;
                        $bindings[$ph] = $item;
                    }
                    $conditions[] = "$key IN (" . implode(', ', $placeholders) . ")";
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