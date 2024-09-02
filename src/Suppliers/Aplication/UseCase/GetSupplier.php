<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\UseCase;

use Src\Suppliers\Aplication\DTO\SupplierResponse;
use Src\Suppliers\Domain\Exception\SupplierNotFoundException;
use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;

class GetSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepository,
    ) {}
    public function execute(int $id): SupplierResponse
    {
        $supplier = $this->supplierRepository->getById($id);
        if (!$supplier) {
            throw new SupplierNotFoundException($id);
        }
        return new SupplierResponse(
            id: $supplier->getId(),
            name: $supplier->getName(),
            contactInfo: $supplier->getContactInfo(),
            phone: $supplier->getPhone(),
            email: $supplier->getEmail(),
            address: $supplier->getAddress(),
            country: $supplier->getCountry()
        );
    }
}
