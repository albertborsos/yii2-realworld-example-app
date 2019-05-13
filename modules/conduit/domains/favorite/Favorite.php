<?php

namespace app\modules\conduit\domains\favorite;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\conduit\traits\ArticleClassPropertyTrait;
use app\modules\conduit\traits\UserClassPropertyTrait;

class Favorite extends \app\modules\conduit\domains\favorite\ar\Favorite
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
