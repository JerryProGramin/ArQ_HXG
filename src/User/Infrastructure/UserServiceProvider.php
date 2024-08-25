<?php

declare(strict_types=1);

namespace Src\User\Infrastructure;

use Src\User\Domain\Service\UserServiceInterface;
use Src\User\Infrastructure\Service\S3UserService;
use Src\User\Domain\Repository\UserRepositoryInterface;
use Src\User\Infrastructure\Persistence\MySQLUserRespository;

class UserServiceProvider
{
    private static array $instances = [];

    public static function register(): void
    {
        // Registrar el singleton para UserRepositoryInterface
        self::$instances[UserRepositoryInterface::class] = function () {
            return new MySQLUserRespository();
        };

        self::$instances[UserServiceInterface::class] = function () {
            return new S3UserService();
        };
    }

    public static function get(string $interface)
    {
        if (!isset(self::$instances[$interface])) {
            throw new \Exception("No instance found for {$interface}");
        }

        // Llamar al closure para obtener la instancia
        return call_user_func(self::$instances[$interface]);
    }
}