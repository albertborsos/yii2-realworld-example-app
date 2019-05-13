<?php

namespace app\modules\api\domains\follow;

use app\modules\api\domains\user\User;

class Follow extends \app\modules\conduit\domains\follow\Follow
{
    protected $userClass = User::class;
}
