<?php

declare(strict_types=1);

namespace Src\Category\Domain\Exception;

use Src\Shader\Domain\Exception\BaseException;

class CategoryNotFoundException extends BaseException
{
    public function __construct(
        int $id,
    )
    {
        parent::__construct("La categoría con ID {$id} no existe.", 404);
    }
}
