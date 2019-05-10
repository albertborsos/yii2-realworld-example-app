<?php

namespace app\traits;

use app\domains\comment\Comment;

trait CommentClassPropertyTrait
{
    protected $commentClass = Comment::class;
}
