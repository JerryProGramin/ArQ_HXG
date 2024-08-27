<?php

declare(strict_types=1);

namespace Src\Category\Aplication\UseCase;

use Src\Category\Aplication\DTO\CategoryRequest;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;

class RegisterCategory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function execute(CategoryRequest $request): void
    {
        $this->categoryRepository->register($request->name, $request->description);
    }
}