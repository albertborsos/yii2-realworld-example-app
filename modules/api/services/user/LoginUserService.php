<?php

namespace app\modules\api\services\user;

use app\components\Service;
use app\modules\api\domains\user\User;
use app\modules\api\services\user\forms\LoginUserForm;

/**
 * Class LoginUserService
 * @package app\modules\api\services\user
 * @property LoginUserForm $form
 */
class LoginUserService extends Service
{
    public function execute()
    {
        /** @var User $model */
        $model = User::findOne(['email' => $this->form->email]);
        $model->updateToken();

        if ($model->save()) {
            return $model->id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
