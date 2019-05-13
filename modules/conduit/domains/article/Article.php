<?php

namespace app\modules\conduit\domains\article;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\conduit\traits\ArticleTagClassPropertyTrait;
use app\modules\conduit\traits\CommentClassPropertyTrait;
use app\modules\conduit\traits\FavoriteClassPropertyTrait;
use app\modules\conduit\traits\TagClassPropertyTrait;
use app\modules\conduit\traits\UserClassPropertyTrait;

class Article extends \app\modules\conduit\domains\article\ar\Article
{
    use UserClassPropertyTrait;
    use ArticleTagClassPropertyTrait;
    use CommentClassPropertyTrait;
    use TagClassPropertyTrait;
    use FavoriteClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
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
