<?php

namespace app\domains\favorite;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\traits\ArticleClassPropertyTrait;
use app\traits\UserClassPropertyTrait;

class Favorite extends \app\domains\favorite\ar\Favorite
{
    use ArticleClassPropertyTrait;
    use UserClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
