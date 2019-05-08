<?php

namespace app\modules\api\domains\comment;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\user\User;

class Comment extends \app\domains\comment\Comment
{
    protected $articleClass = Article::class;
    protected $userClass = User::class;

    public function fields()
    {
        return [
            'id',
            'user_id',
            'article_id',
            'body',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];
    }

}
