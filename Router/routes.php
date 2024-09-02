<?php

use Src\User\Infrastructure\Controller\UserController;
use Src\Category\Infrastructure\Controller\CategoryController;
use Src\Suppliers\Infrastructure\Controller\SupplierController;

// Cargar el autoloading si estás usando Composer
require_once __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

$userController = new UserController($container);
$categoryController = new CategoryController($container);
$supplierController = new SupplierController($container);

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
    },

    'suppliers' => function () use ($supplierController) {
      $supplierController->index();
    },
    'suppliers/{id}' => function ($supplierId) use ($supplierController) {
      $supplierController->show((int)$supplierId);
    },

  ],
  'POST' => [
    'users' => function () use ($userController) {
      $userController->store();
    },
    'categories' => function () use ($categoryController) {
      $categoryController->store();
    },
    'suppliers' => function () use ($supplierController) {
      $supplierController->store();
    },
  ],
  'PUT' => [
    'users/{id}/email' => function ($userId) use ($userController) {
      $userController->updateEmail((int)$userId);
    },
    'users/{id}/password' => function ($userId) use ($userController) {
      $userController->updatePassword((int)$userId);
    },
    'categories/{id}' => function ($categoryId) use ($categoryController) {
      $categoryController->update((int)$categoryId);
    },
    'suppliers/{id}' => function ($supplierId) use ($supplierController) {
      $supplierController->update((int)$supplierId);
    }
  ],

  'DELETE' => [
    'users/{id}' => function ($userId) use ($userController) {
      $userController->delete((int)$userId);
    },
    'categories/{id}' => function ($categoryId) use ($categoryController) {
      $categoryController->delete((int)$categoryId);
    },
    'suppliers/{id}' => function ($supplierId) use ($supplierController) {
      $supplierController->delete((int)$supplierId);
    }
  ],
];
