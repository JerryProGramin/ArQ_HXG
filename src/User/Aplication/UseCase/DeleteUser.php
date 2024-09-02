<?php

declare(strict_types=1);

namespace Src\User\Aplication\UseCase;

use Src\User\Domain\Repository\UserRepositoryInterface;
use Src\User\Domain\Exception\UserNotFoundException;

class DeleteUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(int $userId): void
    {
        $user = $this->userRepository->getById($userId);
        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        $this->userRepository->delete($userId);
    }
}
