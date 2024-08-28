<?php 

declare(strict_types=1);

namespace Src\Profile\Infrastructure\Persistence;

use Src\Shader\Infrastructure\Database\Conexion;
use Src\Profile\Domain\Repository\ProfileRepositoryInterface;
use Src\Profile\Domain\Model\Profiles;
use Src\Shader\Domain\Model\User as ShareUser;

class MySQLProfileRepository implements ProfileRepositoryInterface
{
    private $pdo;
    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getConexion();
    }

    public function getAll(): array{

        $query = 'SELECT id, user_id, name, last_name, name_user, dni FROM profiles';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $profiles = [];
        foreach ($results as $row) {
            $profiles[] = new Profiles(
                id: $row['id'],
                shaderUser: $row['user_id'],
                name: $row['name'],
                lastName: $row['last_name'],
                nameUser:$row['name_user'],
                dni: $row['dni']
            );
        }

        return $profiles;
    }
    public function getById(int $id): ?Profiles
    {
        return null;
    }

    public function register(ShareUser $shaderUser, string $name, string $lastName, string $nameUser, string $dni): void
    {
    }

    public function update(int $id, ShareUser $shaderUser, string $name, string $lastName, string $nameUser, string $dni): void
    {

    }

    public function delete(int $id): void
    {

    }
    
}