<?php

namespace app\modules\api\services\user\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\user\User;
use yii\base\Model;

class UpdateUserForm extends Model
{
    public $email;
    public $password;
    public $username;

    public $token;
    public $id;

    public function __construct(User $model, array $config = [])
    {
        parent::__construct($config);
        $this->id = $model->id;
        $this->email = $model->email;
        $this->password = $model->password;
        $this->username = $model->username;
        $this->token = $model->token;
    }

    public function rules()
    {
        return [
            [['email', 'password', 'username'], HtmlPurifierFilter::class],
            [['email', 'password', 'username'], 'default'],
            [['email', 'password', 'username'], 'required'],

            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'filter' => ['NOT', ['id' => $this->id]]],

            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'filter' => ['NOT', ['id' => $this->id]]],

            [['password', 'username'], 'string'],
        ];
    }
}
