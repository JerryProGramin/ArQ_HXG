<?php 

declare(strict_types = 1);
namespace Src\Shader\Infrastructure\Utils;

class SuccessMessage
{
    /**
     * @param string $message
     */
    public static function successMessage(string $message, $data = null): void
    {

        $response = [
            "success" => true,
            "message" => $message,
        ];
        if ($data) $response["data"] = $data;
        if (is_array($data)) $response["data"] = $data;
        
        echo json_encode($response);
    }
}

