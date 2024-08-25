<?php

use Src\User\Infrastructure\Controller\UserController;

// Cargar el autoloading si estás usando Composer
require_once __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';
$userController = new UserController($container);

return [
  'GET' => [
    'users' => function () use ($userController) {
      $userController->index();
    },
    'users/{id}' => function ($userId) use ($userController) {
      $userController->show((int)$userId);
    }
  ],
  'POST' => [
    // 'users' => function () use ($userController) {
    //   $userController->store();
    // },
  ],
  'PUT' => [
    'posts' => function () {
      require __DIR__ . '/../src/controllers/updatePostController.php';
    },
  ],
  'DELETE' => [
    'posts' => function () {
      require __DIR__ . '/../src/controllers/deletePostController.php';
    },
  ],
];
