<?php

namespace app\domains\follow;

use app\traits\UserClassPropertyTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Follow extends \app\domains\follow\ar\Follow
{
    use UserClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
