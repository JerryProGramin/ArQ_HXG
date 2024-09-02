<?php 

declare(strict_types = 1);

namespace Src\Suppliers\Domain\Model;

class Supplier
{
    public function __construct(
        private int $id,
        private string $name,
        private string $contactInfo,
        private string $phone,
        private string $email,
        private string $address,
        private string $country,
    ){
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getContactInfo(): string
    {
        return $this->contactInfo;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCountry(): string

    {
        return $this->country;
    }
}