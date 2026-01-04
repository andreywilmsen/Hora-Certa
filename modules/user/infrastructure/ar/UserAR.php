<?php

namespace app\modules\user\infrastructure\ar;

use yii\db\ActiveRecord;

class UserAR extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class
        ];
    }
}
