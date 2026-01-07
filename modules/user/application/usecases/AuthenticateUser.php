<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;

class AuthenticateUser
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $email
     * @param string $plainPassword
     * @return User
     * @throws \DomainException
     */

    public function execute(string $email, string $plainPassword): User
    {
        $user = $this->repository->findByEmail($email);

        if (!$user) {
            throw new \DomainException("Invalid email or password.");
        }

        $isValidPassword = \Yii::$app->security->validatePassword($plainPassword, $user->getPasswordHash());

        if (!$isValidPassword) {
            throw new \DomainException("Invalid username or password.");
        }

        return $user;
    }
}
