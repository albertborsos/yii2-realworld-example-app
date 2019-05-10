<?php

namespace app\domains\article;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use app\traits\ArticleTagClassPropertyTrait;
use app\traits\CommentClassPropertyTrait;
use app\traits\FavoriteClassPropertyTrait;
use app\traits\TagClassPropertyTrait;
use app\traits\UserClassPropertyTrait;

class Article extends \app\domains\article\ar\Article
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
