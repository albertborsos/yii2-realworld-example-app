<?php

namespace app\modules\api\domains\article;

use app\modules\api\domains\tag\Tag;

class ArticleTag extends \app\domains\article\ArticleTag
{
    protected $articleClass = Article::class;
    protected $tagClass = Tag::class;
}
