<?php

declare(strict_types=1);

namespace Src\User\Aplication\UseCase;

use Src\User\Aplication\DTO\UserResponse;
use Src\User\Domain\Repository\UserRepositoryInterface;

class GetUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    /**
     * Summary of execute
     * @return UserResponse[]  Array of UserResponse objects
     */
    public function execute(array $params): array
    {
        $users = $this->userRepository->getAll($params);

        return array_map(function ($user) {
            return new UserResponse(
                id: $user->getId(),
                email: $user->getEmail(),
            );
        }, $users);
    }
}
