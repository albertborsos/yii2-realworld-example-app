<?php

namespace app\modules\api\services\user\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\user\User;
use yii\base\Model;

class RegisterUserForm extends Model
{
    public $email;
    public $password;
    public $username;

    public $token;

    public function rules()
    {
        return [
            [['email', 'password', 'username'], HtmlPurifierFilter::class],
            [['email', 'password', 'username'], 'default'],
            [['email', 'password', 'username'], 'required'],

            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],

            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],

            [['password', 'username'], 'string'],
        ];
    }
}
