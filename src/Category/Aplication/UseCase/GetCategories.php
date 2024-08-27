<?php

declare(strict_types=1);

namespace Src\Category\Aplication\UseCase;

use Src\Category\Aplication\DTO\CategoryResponse;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;

class GetCategories
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {}

    /**
     * Summary of execute
     * @return CategoryResponse[]  Array of UserResponse objects
     */
    public function execute(array $params): array
    {
        $categories = $this->categoryRepository->getAll($params);

        return array_map(function ($category) {
            return new CategoryResponse(
                id: $category->getId(),
                name: $category->getName(),
                description: $category->getDescription()
            );
        }, $categories);
    }
}
