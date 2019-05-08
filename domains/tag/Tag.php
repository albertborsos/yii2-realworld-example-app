<?php

namespace app\domains\tag;

use app\traits\ArticleClassPropertyTrait;
use app\traits\ArticleTagClassPropertyTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Tag extends \app\domains\tag\ar\Tag
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
