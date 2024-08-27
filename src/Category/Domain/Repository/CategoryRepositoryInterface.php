<?php

declare(strict_types=1);

namespace Src\Category\Domain\Repository;

use Src\Category\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    /**
     * Summary of getAll
     * @return Category[]  Array of Category objects
     */
    public function getAll(array $params = []): array;
    public function getById(int $categoryId): ?Category;
    public function register(string $name, string $description): void;
    public function update(int $categoryId, string $name, string $description): void;
    public function delete(int $categoryId): void;
}