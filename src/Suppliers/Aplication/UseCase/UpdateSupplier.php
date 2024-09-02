<?php

declare(strict_types=1);

namespace Src\Suppliers\Aplication\UseCase;

use Src\Suppliers\Aplication\DTO\SupplierRequest;
use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;
use Src\Suppliers\Domain\Exception\SupplierNotFoundException;

class UpdateSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $suppliersRepository,
    ) {}

    public function execute(int $suppliersId, SupplierRequest $request): void
    {
        $suppliers = $this->suppliersRepository->getById($suppliersId);
        if (!$suppliers) {
            throw new SupplierNotFoundException($suppliersId);
        }

        $this->suppliersRepository->update(
            $suppliersId, 
            $request->name, 
            $request->contactInfo, 
            $request->phone, 
            $request->email, 
            $request->address, 
            $request->country
        );
    }
}
