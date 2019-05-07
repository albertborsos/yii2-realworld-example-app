<?php

namespace app\modules\api\domains\user;

class User extends \app\domains\user\User
{
    public function fields()
    {
        return [
            'id',
            'email',
            'username',
            'bio',
            'image',
            'token',
        ];
    }
}
