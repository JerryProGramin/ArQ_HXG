<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\UseCase;

use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;
use Src\Suppliers\Domain\Exception\SupplierNotFoundException;

class DeleteSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepository,
    ) {}

    public function execute(int $supplierId): void
    {
        $supplier = $this->supplierRepository->getById($supplierId);
        if (!$supplier) {
            throw new SupplierNotFoundException($supplierId);
        }

        $this->supplierRepository->delete($supplierId);
    }
}
