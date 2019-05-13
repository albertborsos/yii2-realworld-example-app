<?php

namespace app\modules\api\domains\user;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\comment\Comment;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\domains\follow\Follow;

class User extends \app\modules\conduit\domains\user\User
{
    protected $articleClass = Article::class;
    protected $commentClass = Comment::class;
    protected $favoriteClass = Favorite::class;
    protected $followClass = Follow::class;

    public function fields()
    {
        return [
            'email',
            'token',
            'username',
            'bio',
            'image',
        ];
    }

    /**
     * @param string|null $token
     * @throws \yii\base\Exception
     */
    public function updateToken(string $token = null): void
    {
        if ($token) {
            $this->token = $token;

            return;
        }

        $this->token = \Yii::$app->security->generateRandomString();
    }
}
