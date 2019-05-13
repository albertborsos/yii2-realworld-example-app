<?php

namespace app\modules\api\domains\comment;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\user\User;
use Carbon\Carbon;

class Comment extends \app\modules\conduit\domains\comment\Comment
{
    protected $articleClass = Article::class;
    protected $userClass = User::class;

    public function fields()
    {
        return [
            'id',
            'author',
            'article_id',
            'body',
            'createdAt' => function () {
                return (new Carbon($this->created_at))->copy()->utc()->rawFormat('Y-m-d\TH:i:s.u\Z');
            },
            'updatedAt' => function () {
                return (new Carbon($this->updated_at))->copy()->utc()->rawFormat('Y-m-d\TH:i:s.u\Z');
            },
        ];
    }

}
