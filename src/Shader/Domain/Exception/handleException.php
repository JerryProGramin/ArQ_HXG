<?php

declare(strict_types=1);

namespace Src\Shader\Domain\Exception;

use Throwable;

function handleException(Throwable $exception): void
{
  // Establecer el código de estado HTTP según el tipo de excepción
  $statusCode = $exception->getCode() == 0 ? 500 : $exception->getCode(); // Error interno del servidor por defecto
  // Puedes agregar más tipos de excepciones y sus códigos aquí

  // Crear una respuesta JSON
  $response = [
    'success' => false,
    'message' => $exception->getMessage(),
    'file' => $exception->getFile(),
    'line' => $exception->getLine(),
    // 'code' => $statusCode,
  ];

  // Establecer el tipo de contenido y código de estado
  header('Content-Type: application/json', true, $statusCode);
  echo json_encode($response);
}
