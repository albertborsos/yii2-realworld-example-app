<?php

namespace app\modules\conduit\domains\follow;

use app\modules\conduit\traits\UserClassPropertyTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Follow extends \app\modules\conduit\domains\follow\ar\Follow
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
