<?php

declare(strict_types=1);

namespace Src\User\Domain\Exception;

use Src\Shader\Domain\Exception\BaseException;

class UserNotFoundException extends BaseException
{
    public function __construct()
    {
        parent::__construct("User not found.", 404);
    }
}
