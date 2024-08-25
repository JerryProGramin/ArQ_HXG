<?php

declare(strict_types=1);

namespace Src\User\Aplication\UseCase;

use Src\User\Aplication\DTO\UserResponse;
use Src\User\Domain\Exception\UserNotFoundException;
use Src\User\Domain\Repository\UserRepositoryInterface;

class GetUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}
    public function execute(int $userId): UserResponse
    {
        $user = $this->userRepository->getById($userId);
        if (!$user)
            throw new UserNotFoundException();
        return new UserResponse(
            id: $user->getId(),
            email: $user->getEmail(),
        );
    }
}
