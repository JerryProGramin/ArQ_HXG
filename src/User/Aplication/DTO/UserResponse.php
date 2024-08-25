<?php

declare(strict_types=1);

namespace Src\User\Aplication\DTO;

class UserResponse
{
    public function __construct(
        public int $id,
        public string $email,
    ) {
    }
}