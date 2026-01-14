<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\contracts\services\MailService;
use Yii;

class RecoverPassword
{
    private UserRepository $userRepository;
    private MailService $mailService;

    public function __construct(UserRepository $userRepository, MailService $mailService)
    {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    public function execute(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            $token = Yii::$app->security->generateRandomString() . '-' . time();
            $user->setPasswordResetToken($token);
            $this->userRepository->save($user);
            $this->mailService->sendPasswordResetMail($email, $token);
        }
    }
}
