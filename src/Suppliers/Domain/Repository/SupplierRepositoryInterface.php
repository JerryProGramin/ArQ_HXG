<?php 

declare(strict_types = 1);

namespace Src\Suppliers\Domain\Repository;

use Src\Suppliers\Domain\Model\Supplier;

interface SupplierRepositoryInterface
{
    public function getAll(array $params = []): array;
    public function getById(int $supplierId): ?Supplier;
    public function register(string $name, string $contactInfo, string $phone, string $email, string $address, string $country): void;
    public function update(int $supplierId,string $name, string $contactInfo, string $phone, string $email, string $address, string $country): void;
    public function delete(int $supplierId): void;
}