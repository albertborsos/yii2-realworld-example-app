<?php

namespace app\modules\conduit\traits;

use app\modules\conduit\domains\follow\Follow;

trait FollowClassPropertyTrait
{
    protected $followClass = Follow::class;
}
