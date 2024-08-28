<?php

declare(strict_types=1);

use Core\Container;

use Src\User\Domain\Repository\UserRepositoryInterface;
use Src\User\Infrastructure\Persistence\MySQLUserRespository;

use Src\Category\Infrastructure\Persistence\MySQLCategoryRespository;
use Src\Category\Domain\Repository\CategoryRepositoryInterface;

require __DIR__ . '/vendor/autoload.php';

// Crear el contenedor
$container = new Container();

// Registrar en el contenedor las implementaciones de las interfaces usando los singletons del ServiceProvider
$container->set(UserRepositoryInterface::class, function() {
    return new MySQLUserRespository();
});

$container->set(CategoryRepositoryInterface::class, function() {
    return new MySQLCategoryRespository();
});

return $container;