<?php

declare(strict_types=1);

namespace Src\User\Aplication\UseCase;

use Src\User\Aplication\DTO\UserRequest;
use Src\User\Domain\Repository\UserRepositoryInterface;

class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function execute(UserRequest $request): void
    {
        $this->userRepository->register($request->email, $request->password);
    }
}