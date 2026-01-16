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
   * @param int $tenantId
   * @param string $username
   * @param string $firstName
   * @param string $lastName
   * @param string $email
   * @param string $phone
   * @param string $profilePhoto
   * @param string $plainPassword
   * @return User
   * @throws DomainException se o e-mail já estiver cadastrado 
   */

  public function execute(int $tenantId, string $userName, string $firstName, string $lastName, string $email, ?string $phone, ?string $profilePhoto, string $plainPassword): User
  {

    if ($this->repository->findByEmail($email)) {
      throw new DomainException("E-mail already in use.");
    }

    $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

    $user = new User(
      $tenantId,
      $userName,
      $firstName,
      $lastName,
      $email,
      $phone,
      $profilePhoto,
      $passwordHash
    );

    $this->repository->save($user);

    return $user;
  }
}
