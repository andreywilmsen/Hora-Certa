<?php

namespace app\modules\scheduling\contracts\repositories;

use app\modules\scheduling\domain\entities\Professional;

interface ProfessionalRepository
{
    public function save(Professional $professional): void;

    public function remove(Professional $professional): void;

    public function findAll(): array;

    public function findById(int $id): ?Professional;

    public function findByServiceId(int $id): array;
}
