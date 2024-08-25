<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Service;

use Src\User\Domain\Service\UserServiceInterface;

class S3UserService implements UserServiceInterface
{
    public function savePhoto(string $photoBase64): string
    {
        return '';
    }
}