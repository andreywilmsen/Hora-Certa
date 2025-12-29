<?php

namespace app\modules\scheduling\contracts\repositories;

use app\modules\scheduling\domain\entities\Scheduling;

interface SchedulingRepository
{
    public function save(Scheduling $scheduling): void;

    public function remove(Scheduling $scheduling): void;

    public function findById(int $id): ?Scheduling;

    public function findByProfessionalId(int $id): array;

    public function findByServiceId(int $id): array;

    public function findByCustomerId(int $id): array;

    public function findByDate(\DateTimeImmutable $date): array;

    public function findByStatus(string $status): array;
}
