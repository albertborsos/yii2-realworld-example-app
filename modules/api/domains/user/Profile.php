<?php

namespace app\modules\api\domains\user;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\comment\Comment;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\domains\follow\Follow;

class Profile extends \app\modules\conduit\domains\user\User
{
    protected $articleClass = Article::class;
    protected $commentClass = Comment::class;
    protected $favoriteClass = Favorite::class;
    protected $followClass = Follow::class;

    public function fields()
    {
        return [
            'username',
            'bio',
            'image',
            'following',
        ];
    }

    public function getFollowing()
    {
        // #TODO check it is OK?
        return $this->getFollows()->where(['follower_id' => \Yii::$app->user->id])->exists();
    }
}
