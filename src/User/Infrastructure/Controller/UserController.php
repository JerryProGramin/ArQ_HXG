<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Controller;

use Core\Container;
use Src\User\Aplication\UseCase\GetUser;
use Src\User\Aplication\UseCase\GetUsers;
use Src\Shader\Infrastructure\Utils\QueryParams;

class UserController
{
    public function __construct(
        private Container $container,
    ) {}

    public function index()
    {
        $email = QueryParams::query('email');
        $params['email'] = [
            'operator' => 'LIKE',
            'value' => $email,
        ];
        $getUsers = $this->container->get(GetUsers::class);
        $users = $getUsers->execute($params);
        echo json_encode($users);
    }

    public function show(int $userId)
    {
        $getUser = $this->container->get(GetUser::class);
        $user = $getUser->execute($userId);
        echo json_encode($user);
    }
}
