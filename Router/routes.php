<?php

use Src\User\Infrastructure\Controller\UserController;
use Src\Category\Infrastructure\Controller\CategoryController;

// Cargar el autoloading si estás usando Composer
require_once __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

$userController = new UserController($container);
$categoryController = new CategoryController($container);

return [
  'GET' => [
    'users' => function () use ($userController) {
      $userController->index();
    },
    'users/{id}' => function ($userId) use ($userController) {
      $userController->show((int)$userId);
    },

    'categories' => function () use ($categoryController) {
      $categoryController->index();
    },
    'categories/{id}' => function ($categoryId) use ($categoryController) {
      $categoryController->show((int)$categoryId);
    }
  ],
  'POST' => [
    'users' => function () use ($userController) {
      $userController->store();
    },
    'categories' => function () use ($categoryController) {
      $categoryController->store();
    },
  ],
  'PUT' => [
    'categories/{id}' => function ($categoryId) use ($categoryController) {
      $categoryController->update((int)$categoryId);
    },
  ],
  'DELETE' => [
    'categories/{id}' => function ($categoryId) use ($categoryController) {
      $categoryController->delete((int)$categoryId);
    },
  ],
];
