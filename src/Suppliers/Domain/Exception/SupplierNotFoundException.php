<?php

declare(strict_types=1);

namespace Src\Suppliers\Domain\Exception;

use Src\Shader\Domain\Exception\BaseException;

class SupplierNotFoundException extends BaseException
{
    public function __construct(
        int $id,
    )
    {
        parent::__construct("El proveedor con ID {$id} no existe.", 404);
    }
}