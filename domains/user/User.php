<?php

namespace app\domains\user;

use app\domains\user\traits\IdentityTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends \app\domains\user\ar\User implements IdentityInterface
{
    use IdentityTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
