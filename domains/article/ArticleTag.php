<?php

namespace app\domains\article;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\traits\ArticleClassPropertyTrait;
use app\traits\TagClassPropertyTrait;

class ArticleTag extends \app\domains\article\ar\ArticleTag
{
    use ArticleClassPropertyTrait;
    use TagClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
