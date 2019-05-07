<?php

namespace app\modules\api\controllers;

use app\domains\user\ar\User;
use app\modules\api\components\Controller;
use app\modules\api\services\user\forms\RegisterUserForm;
use app\modules\api\services\user\RegisterUserService;
use yii\helpers\ArrayHelper;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['login', 'create'];

        return $behaviors;
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
                return \app\domains\user\User::findOne($id);
            }
        }

        return $form;
    }

    public function actionLogin()
    {
        $request = \Yii::$app->request;

        return [
            'user' => [
                'email' => ArrayHelper::getValue($request->post(), 'user.email'),
                'username' => ArrayHelper::getValue($request->post(), 'user.username', 'username'),
                'bio' => ArrayHelper::getValue($request->post(), 'user.bio', 'bio'),
                'image' => ArrayHelper::getValue($request->post(), 'user.image', 'image'),
                'token' => ArrayHelper::getValue($request->post(), 'user.token', 'token'),
            ],
        ];
    }

    public function actionIndex()
    {
        return 'hello';
    }

    public function actionUpdate()
    {

    }
}
