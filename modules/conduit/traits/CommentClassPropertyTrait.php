<?php

namespace app\modules\conduit\traits;

use app\modules\conduit\domains\comment\Comment;

trait CommentClassPropertyTrait
{
    protected $commentClass = Comment::class;
}
