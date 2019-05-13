<?php

namespace app\modules\conduit\domains\article;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\conduit\traits\ArticleClassPropertyTrait;
use app\modules\conduit\traits\TagClassPropertyTrait;

class ArticleTag extends \app\modules\conduit\domains\article\ar\ArticleTag
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
