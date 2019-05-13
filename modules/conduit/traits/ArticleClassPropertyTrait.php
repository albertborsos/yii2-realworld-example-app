<?php

namespace app\modules\conduit\traits;

use app\modules\conduit\domains\article\Article;

trait ArticleClassPropertyTrait
{
    protected $articleClass = Article::class;
}
