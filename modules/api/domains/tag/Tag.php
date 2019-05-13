<?php

namespace app\modules\api\domains\tag;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\article\ArticleTag;

class Tag extends \app\modules\conduit\domains\tag\Tag
{
    protected $articleClass = Article::class;
    protected $articleTagClass = ArticleTag::class;

    public function fields()
    {
        return [
            'name',
        ];
    }
}
