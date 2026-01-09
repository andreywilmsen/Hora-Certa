<?php

namespace app\modules\user\infrastructure\services;

use app\modules\user\domain\contracts\services\TokenService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use app\modules\user\domain\entities\User;
use Yii;

class JwtService implements TokenService
{
    private string $key;
    private string $algorithm = 'HS256';

    public function __construct()
    {
        $this->key = Yii::$app->params['jwtSecretKey'];
    }

    public function generateToken(User $user): string
    {
        $now = time();
        $payload = [
            'iat' => $now,
            'exp' => $now + (60 * 60),
            'uid' => $user->getId(),
        ];

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    public function validateToken(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->key, $this->algorithm));
        } catch (\Exception $e) {
            return null;
        }
    }
}
