<?php

namespace app\traits;

use app\domains\user\User;

trait UserClassPropertyTrait
{
    protected $userClass = User::class;
}
