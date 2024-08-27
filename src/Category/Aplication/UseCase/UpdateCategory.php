<?php

declare(strict_types=1);

namespace Src\Category\Aplication\UseCase;

use Src\Category\Aplication\DTO\CategoryRequest;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;
use Src\Category\Domain\Exception\CategoryNotFoundException;

class UpdateCategory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function execute(int $categoryId, CategoryRequest $request): void
    {
        $category = $this->categoryRepository->getById($categoryId);
        if (!$category) {
            throw new CategoryNotFoundException($categoryId);
        }

        $this->categoryRepository->update($categoryId, $request->name, $request->description);
    }
}