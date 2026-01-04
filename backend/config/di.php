<?php

use app\modules\user\contracts\repositories\UserRepository;
use app\modules\user\infrastructure\repositories\ActiveRecordUserRepository;

return [
    UserRepository::class => ActiveRecordUserRepository::class,
];
