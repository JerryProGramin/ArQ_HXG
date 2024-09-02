<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\DTO;

class SupplierResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $contactInfo,
        public string $phone,
        public string $email,
        public string $address,
        public string $country,
    ) {}
}
