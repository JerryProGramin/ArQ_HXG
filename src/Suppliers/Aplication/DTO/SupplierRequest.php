<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\DTO;

class SupplierRequest
{
    public function __construct(
        public string $name,
        public string $contactInfo,
        public string $phone,
        public string $email,
        public string $address,
        public string $country,
    ) {
    }
}