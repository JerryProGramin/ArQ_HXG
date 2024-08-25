<?php

declare(strict_types=1);

namespace Src\User\Domain\Repository;

use Src\User\Domain\Model\User;

interface UserRepositoryInterface
{
    /**
     * Summary of getAll
     * @return User[]  Array of User objects
     */
    public function getAll(array $params = []): array;
    public function getById(int $userId): ?User;
    public function register(string $email, string $password): void;
    public function updateEmail(int $userId, string $email): void;
    public function updatePassword(int $userId, string $password): void;
    public function delete(int $userId): void;
}
