<?php

namespace app\modules\api\services\user;

use app\modules\api\domains\user\User;
use app\modules\api\services\user\forms\RegisterUserForm;
use yii\base\Component;

class RegisterUserService extends Component
{
    /** @var RegisterUserForm */
    private $form;

    public function __construct(RegisterUserForm $form, array $config = [])
    {
        parent::__construct($config);
        $this->form = $form;
    }

    /**
     * @return bool|int
     * @throws \yii\base\Exception
     */
    public function execute()
    {
        $this->form = $this->hashPassword($this->form);
        $this->form = $this->setToken($this->form);

        $model = new User();
        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }

    /**
     * @param RegisterUserForm $form
     * @return RegisterUserForm
     * @throws \yii\base\Exception
     */
    private function hashPassword(RegisterUserForm $form)
    {
        $form->password = \Yii::$app->security->generatePasswordHash($form->password);

        return $form;
    }

    private function setToken(RegisterUserForm $form)
    {
        $form->token = \Yii::$app->security->generateRandomString(32);

        return $form;
    }
}
