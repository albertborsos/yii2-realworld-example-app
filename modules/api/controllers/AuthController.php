<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Controller;
use app\modules\api\domains\user\User;
use app\modules\api\services\user\forms\LoginUserForm;
use app\modules\api\services\user\forms\RegisterUserForm;
use app\modules\api\services\user\forms\UpdateUserForm;
use app\modules\api\services\user\LoginUserService;
use app\modules\api\services\user\RegisterUserService;
use app\modules\api\services\user\UpdateUserService;
use yii\rest\OptionsAction;

class AuthController extends Controller
{
    protected $modelAlias = 'user';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['login', 'create'];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    public function verbs()
    {
        return [
            'login' => ['POST', 'OPTIONS'],
        ];
    }

    /** Registration */
    public function actionCreate()
    {
        $form = new RegisterUserForm();

        if ($form->load(\Yii::$app->request->post(), 'user') && $form->validate()) {
            $service = new RegisterUserService($form);
            if ($id = $service->execute()) {
                return \app\modules\api\domains\user\User::findOne($id);
            }
        }

        return $form;
    }

    public function actionLogin()
    {
        $form = new LoginUserForm();

        if ($form->load(\Yii::$app->request->post(), 'user') && $form->validate()) {
            $service = new LoginUserService($form);
            if ($id = $service->execute()) {
                return \app\modules\api\domains\user\User::findOne($id);
            }
        }

        return $form;
    }

    public function actionIndex()
    {
        return User::findOne(\Yii::$app->user->id);
    }

    public function actionUpdate()
    {
        $model = User::findOne(\Yii::$app->user->id);
        $form = new UpdateUserForm($model);

        if ($form->load(\Yii::$app->request->post(), 'user') && $form->validate()) {
            $service = new UpdateUserService($form, $model);
            if ($id = $service->execute()) {
                return \app\modules\api\domains\user\User::findOne($id);
            }
        }

        return $form;
    }
}
