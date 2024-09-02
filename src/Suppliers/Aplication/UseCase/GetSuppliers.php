<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\UseCase;

use Src\Suppliers\Aplication\DTO\SupplierResponse;
use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;

class GetSuppliers
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepository,
    ) {}

    public function execute(array $params): array
    {
        $suppliers = $this->supplierRepository->getAll($params);

        return array_map(function ($supplier) {
            return new SupplierResponse(
                id: $supplier->getId(),
                name: $supplier->getName(),
                contactInfo: $supplier->getContactInfo(),
                phone: $supplier->getPhone(),
                email: $supplier->getEmail(),
                address: $supplier->getAddress(),
                country: $supplier->getCountry()
            );
        }, $suppliers);
    }
}
