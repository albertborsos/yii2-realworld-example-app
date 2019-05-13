<?php

namespace app\modules\api\domains\article;

use app\modules\api\domains\tag\Tag;

class ArticleTag extends \app\modules\conduit\domains\article\ArticleTag
{
    protected $articleClass = Article::class;
    protected $tagClass = Tag::class;
}
