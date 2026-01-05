<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use Yii;

class GetAllUsers
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $users = $this->repository->findAll();
        if (!$users) {
            throw new \DomainException("List users be empty.");
        }

        return $users;
    }
}
