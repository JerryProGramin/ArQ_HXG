<?php

declare(strict_types=1);

namespace Src\User\Aplication\DTO;

class UserPhotoRequest
{
    public function __construct(
        public int $userId
    ) {
    }
}