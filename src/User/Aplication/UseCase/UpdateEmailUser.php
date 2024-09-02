<?php

declare(strict_types=1);

namespace Src\User\Aplication\UseCase;

use Src\User\Aplication\DTO\UserRequest;
use Src\User\Domain\Repository\UserRepositoryInterface;
use Src\User\Domain\Exception\UserNotFoundException;

class UpdateEmailUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(int $userId, UserRequest $request): void
    {
        $user = $this->userRepository->getById($userId);
        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        $this->userRepository->updateEmail($userId, $request->email);
    }
}
