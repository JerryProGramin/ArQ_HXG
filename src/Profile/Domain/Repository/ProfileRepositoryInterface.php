<?php 

declare(strict_types=1);

namespace Src\Profile\Domain\Repository;

use Src\Profile\Domain\Model\Profiles;
use Src\Shader\Domain\Model\User as ShareUser;
interface ProfileRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $profileId): ?Profiles;
    public function register(ShareUser $shaderUser, string $name, string $lastName, string $nameUser, string $dni): void;
    public function update(int $profileId,ShareUser $shaderUser, string $name, string $lastName, string $nameUser, string $dni): void;
    public function delete(int $profileId): void;
}