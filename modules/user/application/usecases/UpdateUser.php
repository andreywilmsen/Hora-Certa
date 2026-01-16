<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;

class UpdateUser
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @param string $userName
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string|null $phone
     * @return User
     */
    
    public function execute(int $id, string $userName, string $firstName, string $lastName, string $email, ?string $phone)
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            throw new \DomainException("User with ID {$id} not found.");
        }

        $user->updateUser($userName, $firstName, $lastName, $email, $phone);

        $this->repository->save($user);

        return $user;
    }
}
