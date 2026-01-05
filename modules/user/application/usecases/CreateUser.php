<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;
use DomainException;

class CreateUser
{

  private UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  /** 
   * @param string $username
   * @param string $firstName
   * @param string $lastName
   * @param string $email
   * @param string $plainPassword
   * @return User
   * @throws DomainException se o e-mail já estiver cadastrado 
   */

  public function execute(string $userName, string $firstName, string $lastName, string $email, string $plainPassword): User
  {

    if ($this->repository->findByEmail($email)) {
      throw new DomainException("E-mail already in use.");
    }

    $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

    $user = new User(
      $userName,
      $firstName,
      $lastName,
      $email,
      $passwordHash
    );

    $this->repository->save($user);

    return $user;
  }
}
