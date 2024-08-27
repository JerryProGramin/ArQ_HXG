<?php

declare(strict_types=1);

namespace Src\Category\Aplication\DTO;

class CategoryRequest
{
    public function __construct(
        public string $name,
        public string $description
    ) {
    }
}