<?php

declare(strict_types=1);

namespace Src\Category\Aplication\DTO;

class CategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description
    ) {
    }
}