<?php

declare(strict_types=1);

namespace Src\Shader\Domain\Model;

class User
{
    public function __construct(
        private int $id,
        private string $email 
    ){
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}