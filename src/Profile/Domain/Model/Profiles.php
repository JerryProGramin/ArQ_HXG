<?php 
declare(strict_types=1);

namespace Src\Profile\Domain\Model;

use Src\Shader\Domain\Model\User as ShaderUser;

class Profiles 
{
    public function __construct(
        private int $id,
        private ShaderUser $shaderUser,
        private string $name,
        private string $lastName,
        private string $nameUser,
        private string $dni
    ){
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getShaderUser(): ShaderUser  
    {
        return $this->shaderUser;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getLastName(): string 
    {
        return $this->lastName;
    }

    public function getNameUser(): string 
    {
        return $this->nameUser;
    }

    public function getDni(): string 
    {
        return $this->dni;
    }
}