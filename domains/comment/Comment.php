<?php

namespace app\domains\comment;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\traits\ArticleClassPropertyTrait;
use app\traits\UserClassPropertyTrait;

class Comment extends \app\domains\comment\ar\Comment
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
