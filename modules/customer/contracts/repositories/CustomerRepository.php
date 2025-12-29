<?php

namespace app\modules\customer\contracts\repositories;

use app\modules\customer\domain\entities\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;

    public function remove(Customer $customer): void;

    public function findById(int $id): ?Customer;

    public function findByPhone(string $phone): ?Customer;

    public function findAll(): array;

    public function exists(int $id): bool;
}
