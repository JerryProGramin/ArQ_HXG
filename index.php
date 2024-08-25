<?php

// Configura el autoloading si estás usando Composer
require 'vendor/autoload.php';

// Incluye el archivo del enrutador
require 'Router/Router.php';

// Incluye el archivo del manejador de excepciones
require 'src/Shader/Domain/Exception/handleException.php';

// Configura el manejador de excepciones global
set_exception_handler('src\Shader\Domain\Exception\handleException');

// Usa el namespace del enrutador
use Router\Router;

header('Content-Type: application/json; charset=utf-8');

// Crea una instancia del enrutador y carga las rutas
$router = new Router(__DIR__ . '/Router/routes.php');

// Obtiene la URI y el método de la solicitud
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Despacha la solicitud al enrutador
$router->dispatch($requestMethod, $requestUri);
