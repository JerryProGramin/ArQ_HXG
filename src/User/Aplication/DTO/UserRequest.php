<?php

declare(strict_types=1);

namespace Src\User\Aplication\DTO;

class UserRequest
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
        $this->validateEmail($email);
    }

    public function validateEmail(string $email): void
    {
        // validamos el formato: tiene @, tiene un dominio, dominios permitidos
    }
}