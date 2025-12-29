<?php

namespace app\modules\scheduling\contracts\repositories;

use app\modules\scheduling\domain\entities\Availability;

interface AvailabilityRepository
{
    public function save(Availability $availability): void;

    public function remove(Availability $availability): void;

    public function findByProfessionalId(int $id): array;
}
