<?php

namespace app\modules\user\application\usecases;

use app\modules\user\contracts\repositories\UserRepository;

class UpdateUser
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, string $userName, string $firstName, string $lastName, string $email)
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            throw new \DomainException("User with ID {$id} not found.");
        }

        $user->updateUser($userName, $firstName, $lastName, $email);

        $this->repository->save($user);

        return $user;
    }
}
