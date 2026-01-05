<?php

namespace app\modules\user\infrastructure\repositories;

use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;
use app\modules\user\infrastructure\ar\UserAR;
use RuntimeException;
use Yii;

class ActiveRecordUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        $ar = $user->getId() ? UserAR::findOne($user->getId()) : new UserAR();

        $ar->username = $user->getUserName();
        $ar->first_name = $user->getFirstName();
        $ar->last_name = $user->getLastName();
        $ar->email = $user->getEmail();
        $ar->password_hash = $user->getPasswordHash();

        if ($ar->isNewRecord) {
            $ar->auth_key = Yii::$app->security->generateRandomString();
            $ar->status = 10;
        }

        if (!$ar->save()) {
            throw new RuntimeException("Error saving user.");
        }

        if ($user->getId() === null) {
            $user->setId($ar->id);
        }
    }

    public function remove(User $user): void
    {
        $ar = UserAR::findOne($user->getId());

        if ($ar) {
            $ar->delete();
        }
    }

    public function findAll(): array
    {
        $ars = UserAR::find()->all();

        return array_map(
            fn(UserAR $ar) => $this->mapToDomain($ar),
            $ars
        );
    }

    public function findById(int $id): ?User
    {
        $ar = UserAR::findOne($id);

        return $ar ? $this->mapToDomain($ar) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $ar = UserAR::find()->where(['email' => $email])->one();

        return $ar ? $this->mapToDomain($ar) : null;
    }

    private function mapToDomain(UserAR $ar): User
    {
        $user = new User(
            $ar->username,
            $ar->first_name,
            $ar->last_name,
            $ar->email,
            $ar->password_hash
        );

        $user->setId($ar->id);

        return $user;
    }
}
