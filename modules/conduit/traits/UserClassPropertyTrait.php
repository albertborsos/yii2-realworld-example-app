<?php

namespace app\modules\conduit\traits;

use app\modules\conduit\domains\user\User;

trait UserClassPropertyTrait
{
    protected $userClass = User::class;
}
