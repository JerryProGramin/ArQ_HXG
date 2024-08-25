<?php

declare(strict_types=1);

namespace Src\Category\Domain\Repository;

use Src\Category\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    /**
     * Summary of getAll
     * @return User[]  Array of User objects
     */
    public function getAll(array $params = []): array;
    public function getById(int $userId): ?Category;
    public function register(string $name, string $description): void;
    public function update(int $userId, string $name, string $description): void;
    public function delete(int $userId): void;
}