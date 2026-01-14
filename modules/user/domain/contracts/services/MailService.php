<?php

namespace app\modules\user\domain\contracts\services;

interface MailService {
    public function sendPasswordResetMail(string $email, string $token): void;
}