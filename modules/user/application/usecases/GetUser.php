<?php

namespace app\modules\user\application\usecases;

use app\modules\user\contracts\repositories\UserRepository;

class GetUser
{
  private UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(int $id)
  {

    $user = $this->repository->findById($id);

    if (!$user) {
      throw new \DomainException("User cannot be registered.");
    }

    return $user;
  }
}
