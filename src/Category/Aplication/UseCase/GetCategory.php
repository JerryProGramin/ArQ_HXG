<?php

declare(strict_types=1);

namespace Src\Category\Aplication\UseCase;

use Src\Category\Aplication\DTO\CategoryResponse;
use Src\Category\Domain\Exception\CategoryNotFoundException;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;

class GetCategory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {}
    public function execute(int $categoryId): CategoryResponse
    {
        $category = $this->categoryRepository->getById($categoryId);
        if (!$category) {
            throw new CategoryNotFoundException($categoryId);
        }
        return new CategoryResponse(
            id: $category->getId(),
            name: $category->getName(),
            description: $category->getDescription()
        );
    }
}
