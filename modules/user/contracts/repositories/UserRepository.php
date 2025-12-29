<?php

namespace app\modules\user\contracts\repositories;

use app\modules\user\domain\entities\User;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(int $id): ?User;

    public function remove(User $user): void;

    public function findAll(): array;

    public function findByEmail(string $email): ?User;
}
