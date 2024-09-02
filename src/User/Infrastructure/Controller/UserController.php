<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Controller;

use Core\Container;
use Src\User\Aplication\DTO\UserRequest;
use Src\User\Aplication\UseCase\GetUser;
use Src\User\Aplication\UseCase\GetUsers;
use Src\User\Aplication\UseCase\RegisterUser;
use Src\User\Aplication\UseCase\UpdateEmailUser;
use Src\User\Aplication\UseCase\UpdatePasswordUser;
use Src\User\Aplication\UseCase\DeleteUser;
use Src\Shader\Infrastructure\Utils\QueryParams;
use Src\Shader\Infrastructure\Utils\SuccessMessage;

class UserController
{
    public function __construct(
        private Container $container,
    ) {}

    public function index()
    {
        $allowedFilters = [
            'email' => 'LIKE',
        ];

        $params = QueryParams::query($allowedFilters);
        $getUsers = $this->container->get(GetUsers::class);
        $users = $getUsers->execute($params);
        SuccessMessage::successMessage("OK", $users);
    }

    public function show(int $userId)
    {
        $getUser = $this->container->get(GetUser::class);
        $user = $getUser->execute($userId);

        SuccessMessage::successMessage("OK", $user);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $userRequest = new UserRequest(
            email: $data['email'],
            password: $data['password'],
        );

        $registerUser = $this->container->get(RegisterUser::class);
        $registerUser->execute($userRequest);
        SuccessMessage::successMessage("Usuario registrado");    
    }

    public function updateEmail(int $userId)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userRequest = new UserRequest(
            email: $data['email'],
        );

        $updateEmailUser = $this->container->get(UpdateEmailUser::class);
        $updateEmailUser->execute($userId, $userRequest);  
        SuccessMessage::successMessage("Email actualizado");
    }


    public function updatePassword(int $userId)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userRequest = new UserRequest(
            password: $data['password']
        );

        $updatePasswordUser = $this->container->get(UpdatePasswordUser::class);
        $updatePasswordUser->execute($userId, $userRequest);
        SuccessMessage::successMessage("Contraseña actualizada");
    }


    public function delete(int $userId)
    {
        $deleteUser = $this->container->get(DeleteUser::class);
        $deleteUser->execute($userId);
        SuccessMessage::successMessage("Usuario eliminado");
    }
}
