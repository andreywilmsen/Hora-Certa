<?php

namespace app\modules\user\application\dtos;

use app\modules\user\domain\entities\User;

class UserResponseDTO
{
    public function __construct(public int $id, public string $userName, public string $email, public string $fullName, public ?string $phone, public ?string $profilePhoto) {}

    public static function fromEntity(User $user): self
    {
        return new self($user->getId(), $user->getUserName(), $user->getEmail(), $user->getFullName(), $user->getPhone(), $user->getProfilePhoto());
    }

    public static function fromEntityList(array $users): array
    {
        return array_map(fn(User $user) => self::fromEntity($user), $users);
    }
}
