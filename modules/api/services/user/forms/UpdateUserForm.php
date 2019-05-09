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
    public $image;
    public $bio;

    /** @var User */
    private $model;

    public function __construct(User $model, array $config = [])
    {
        parent::__construct($config);

        $this->model = $model;

        $this->email = $model->email;
        $this->password = $model->password;
        $this->username = $model->username;
        $this->image = $model->image;
        $this->bio = $model->bio;
    }

    public function rules()
    {
        return [
            [['email', 'password', 'username', 'image', 'bio'], HtmlPurifierFilter::class],
            [['email', 'password', 'username', 'image', 'bio'], 'default'],

            [['password', 'username', 'image', 'bio'], 'string'],

            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'filter' => ['NOT', ['id' => $this->model->id]]],

            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'filter' => ['NOT', ['id' => $this->model->id]]],
        ];
    }
}
