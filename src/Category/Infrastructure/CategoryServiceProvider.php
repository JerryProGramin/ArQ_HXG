<?php

declare(strict_types=1);

namespace Src\User\Infrastructure;

use Src\Category\Domain\Repository\CategoryRepositoryInterface;
use Src\Category\Infrastructure\Persistence\MySQLCategoryRespository;

class CategoryServiceProvider
{
    private static array $instances = [];

    public static function register(): void
    {
        // Registrar el singleton para UserRepositoryInterface
        self::$instances[CategoryRepositoryInterface::class] = function () {
            return new MySQLCategoryRespository();
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