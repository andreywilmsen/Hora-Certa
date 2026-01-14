<?php

namespace app\modules\user\infrastructure\services;

use app\modules\user\domain\contracts\services\MailService;
use Yii;

class YiiMailService implements MailService
{
    public function sendPasswordResetMail(string $email, string $token): void
    {
        $baseUrl = "http://localhost:3000/reset-password";
        $link = $baseUrl . "?token=" . $token;

        Yii::$app->mailer->compose()
            ->setFrom(['noreply@horacerta.com' => 'Hora Certa - Serviço de Agendamento '])
            ->setTo($email)
            ->setSubject('Recuperação de Senha - Hora Certa')
            ->setHtmlBody("
                <p>Você solicitou a recuperação de senha para sua conta no Hora Certa.</p>
                <p>Clique no link abaixo para cadastrar uma nova senha:</p>
                <p><a href='{$link}'>{$link}</a></p>
                <p>Este link expirará em 1 hora.</p>
            ")
            ->setTextBody("Use este link para recuperar sua senha: " . $link)
            ->send();
    }
}