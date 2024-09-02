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
    // public static function query(string $parameter, ?string $default = null): ?string
    // {
    //     if (isset($_GET[$parameter])) {
    //         $param = $_GET[$parameter];
    //         return $param;
    //     } else {
    //         return $default;
    //     }
    // }
    public static function query(array $allowedFilters): array
    {
        $params = [];

        foreach ($allowedFilters as $filter => $operator) {
            if (isset($_GET[$filter])) {
                $params[$filter] = [
                    'operator' => $operator,
                    'value' => $_GET[$filter],
                ];
            }
        }

        return $params;
    }
}
