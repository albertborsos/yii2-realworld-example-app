<?php

namespace app\modules\conduit\domains\tag;

use app\modules\conduit\traits\ArticleClassPropertyTrait;
use app\modules\conduit\traits\ArticleTagClassPropertyTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Tag extends \app\modules\conduit\domains\tag\ar\Tag
{
    use ArticleClassPropertyTrait;
    use ArticleTagClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
