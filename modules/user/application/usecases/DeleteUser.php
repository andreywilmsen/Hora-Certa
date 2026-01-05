<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use DomainException;

class DeleteUser
{

    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): void
    {

        $user = $this->repository->findById($id);

        if (!$user) {
            throw new DomainException("User with ID {$id} not found.");
        }

        $this->repository->remove($user);
    }
}
