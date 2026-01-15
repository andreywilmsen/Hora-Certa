<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use Yii;

class ResetPassword
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $token, string $newPassword)
    {
        $user = $this->userRepository->findByResetToken($token);

        if (!$user || !$user->isResetTokenValid($token)) {
            throw new \DomainException('Invalid or expired token.');
        }

        $passwordHash = Yii::$app->security->generatePasswordHash($newPassword);
        $user->resetPassword($passwordHash);
        $this->userRepository->save($user);
    }
}
