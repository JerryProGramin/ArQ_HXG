<?php

declare(strict_types=1);

namespace Src\Suppliers\Infrastructure\Controller;

use Core\Container;
use Src\Suppliers\Aplication\DTO\SupplierRequest;
use Src\Shader\Infrastructure\Utils\QueryParams;
use Src\Suppliers\Aplication\UseCase\GetSuppliers;
use Src\Suppliers\Aplication\UseCase\GetSupplier;
use Src\Suppliers\Aplication\UseCase\RegisterSupplier;
use Src\Suppliers\Aplication\UseCase\UpdateSupplier;
use Src\Suppliers\Aplication\UseCase\DeleteSupplier;
use Src\Shader\Infrastructure\Utils\SuccessMessage;

class SupplierController
{
    public function __construct(
        private Container $container,
    ) {}

    public function index()
    {
        $allowedFilters = [
            'name' => 'LIKE',
            'contact_info' => '=',
            'phone' => '=',
            'email' => '=',
            'address' => '=',
            'country' => '=',
        ];

        $params = QueryParams::query($allowedFilters);
        
        $getSuppliers = $this->container->get(GetSuppliers::class);
        $suppliers = $getSuppliers->execute($params);

        SuccessMessage::successMessage("OK", $suppliers);
    }

    public function show(int $id){
        $getSupplier = $this->container->get(GetSupplier::class);
        $supplier = $getSupplier->execute($id);

        SuccessMessage::successMessage("OK", $supplier);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $supplierRequest = new SupplierRequest(
            name: $data['name'],
            contactInfo: $data['contact_info'],
            phone: $data['phone'],
            email: $data['email'],
            address: $data['address'],
            country: $data['country'],
        );
        
        $registerSupplier = $this->container->get(RegisterSupplier::class);
        $registerSupplier->execute($supplierRequest);
        
        SuccessMessage::successMessage("Proveedor registrado");
    }

    public function update(int $id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $supplierRequest = new SupplierRequest(
            name: $data['name'],
            contactInfo: $data['contact_info'],
            phone: $data['phone'],
            email: $data['email'],
            address: $data['address'],
            country: $data['country'],
        );
        
        $updateSupplier = $this->container->get(UpdateSupplier::class);
        $updateSupplier->execute($id, $supplierRequest);
        
        SuccessMessage::successMessage("Proveedor actualizado");
    }
    
    public function delete(int $id)
    {
        $deleteSupplier = $this->container->get(DeleteSupplier::class);
        $deleteSupplier->execute($id);
        
        SuccessMessage::successMessage("Proveedor eliminado");
    }
}
