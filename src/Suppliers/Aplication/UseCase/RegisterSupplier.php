<?php 

declare(strict_types = 1);

namespace Src\Suppliers\Aplication\UseCase;

use Src\Suppliers\Domain\Repository\SupplierRepositoryInterface;
use Src\Suppliers\Aplication\DTO\SupplierRequest;

class RegisterSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepository,
    ){
    }

    public function execute(SupplierRequest $request): void
    {
        $this->supplierRepository->register(
            $request->name, 
            $request->contactInfo, 
            $request->phone, 
            $request->email, 
            $request->address, 
            $request->country
        );
    }
}