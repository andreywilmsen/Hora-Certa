<?php

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\contracts\services\MailService;
use app\modules\user\infrastructure\repositories\ActiveRecordUserRepository;
use app\modules\user\infrastructure\services\YiiMailService;

return [
    UserRepository::class => ActiveRecordUserRepository::class,
    MailService::class => YiiMailService::class,
];
