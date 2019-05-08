<?php

namespace app\modules\api\services\user\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\user\User;
use yii\base\Model;

class LoginUserForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], HtmlPurifierFilter::class],
            [['email', 'password'], 'default'],
            [['email', 'password'], 'required'],

            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email'],

            [['password'], 'validatePassword', 'when' => function () { return empty($this->errors); }],
        ];
    }

    public function validatePassword()
    {
        $user = User::findOne(['email' => $this->email]);

        if (\Yii::$app->security->validatePassword($this->password, $user->password) === false) {
            $this->addError('password', \Yii::t('app', 'Invalid password'));
        }
    }
}
