<?php

namespace app\modules\scheduling\contracts\repositories;

use app\modules\scheduling\domain\entities\Service;

interface ServiceRepository
{
    public function save(Service $service): void;

    public function remove(Service $service): void;

    public function findById(int $id): ?Service;

    public function findByServiceName(string $serviceName): ?Service;
}
