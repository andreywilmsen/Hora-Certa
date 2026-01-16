<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;

class UpdateProfilePhoto
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $userId, string $photoPath): User
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new \DomainException("User not found.");
        }
        $oldPhoto = $user->getProfilePhoto();

        if ($oldPhoto && $oldPhoto !== $photoPath) {
            $oldFilePath = \Yii::getAlias('@webroot') . $oldPhoto;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $user->updateProfilePhoto($photoPath);
        $this->userRepository->save($user);

        return $user;
    }
}
