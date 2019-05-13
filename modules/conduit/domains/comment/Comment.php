<?php

namespace app\modules\conduit\domains\comment;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\conduit\traits\ArticleClassPropertyTrait;
use app\modules\conduit\traits\UserClassPropertyTrait;

class Comment extends \app\modules\conduit\domains\comment\ar\Comment
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->getUser();
    }
}
