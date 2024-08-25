<?php

declare(strict_types=1);

namespace Core\Exceptions;
use Exception;

class ContainerException extends Exception
{
    public function __construct()
    {
        parent::__construct('', 500);
    }
}