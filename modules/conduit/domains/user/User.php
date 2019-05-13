<?php

namespace app\modules\conduit\domains\user;

use app\modules\conduit\domains\user\traits\IdentityTrait;
use app\modules\conduit\traits\ArticleClassPropertyTrait;
use app\modules\conduit\traits\CommentClassPropertyTrait;
use app\modules\conduit\traits\FavoriteClassPropertyTrait;
use app\modules\conduit\traits\FollowClassPropertyTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends \app\modules\conduit\domains\user\ar\User implements IdentityInterface
{
    use IdentityTrait;
    use ArticleClassPropertyTrait;
    use CommentClassPropertyTrait;
    use FavoriteClassPropertyTrait;
    use FollowClassPropertyTrait;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'blameable' => BlameableBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ]);
    }
}
