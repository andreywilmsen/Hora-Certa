<?php

namespace app\modules\user\domain\contracts\services;

use app\modules\user\domain\entities\User;

interface TokenService
{
    public function generateToken(User $user): string;

    public function validateToken(string $token): ?object;
}
