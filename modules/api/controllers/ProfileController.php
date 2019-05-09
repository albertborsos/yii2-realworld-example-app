<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    /**
     * @param $username
     * @return \app\modules\api\domains\user\Profile|null
     * @throws NotFoundHttpException
     */
    public function actionView($username)
    {
        $model = \app\modules\api\domains\user\Profile::findOne(['username' => $username]);

        if (empty($model)) {
            throw new NotFoundHttpException('Username not found.');
        }

        return $model;
    }
}
