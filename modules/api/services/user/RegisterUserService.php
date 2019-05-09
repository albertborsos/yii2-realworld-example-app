<?php

namespace app\modules\api\services\user;

use app\components\Service;
use app\modules\api\domains\user\User;
use app\modules\api\services\user\forms\RegisterUserForm;

/**
 * Class RegisterUserService
 * @package app\modules\api\services\user
 *
 * @property RegisterUserForm $form
 */
class RegisterUserService extends Service
{
    /**
     * @return bool|int
     * @throws \yii\base\Exception
     */
    public function execute()
    {
        $this->form = $this->hashPassword($this->form);

        $model = new User();
        $model->setAttributes($this->form->attributes);
        $model->updateToken();

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
}
