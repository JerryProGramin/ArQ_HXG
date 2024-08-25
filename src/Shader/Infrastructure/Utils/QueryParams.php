<?php

declare(strict_types=1);

namespace Src\Shader\Infrastructure\Utils;

class QueryParams
{
    /**
     * Definir el parámetro que quiero. -> success
     * Validar que exista dicho parámetro. -> success
     * Que me devuelva un valor por defecto en caso de que no exista. -> success
     */
    public static function query(string $parameter, ?string $default = null): ?string
    {
        if (isset($_GET[$parameter])) {
            $param = $_GET[$parameter];
            return $param;
        } else {
            return $default;
        }
    }
}
