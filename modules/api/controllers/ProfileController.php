<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Controller;
use app\modules\api\domains\follow\Follow;
use app\modules\api\domains\user\Profile;
use app\modules\api\services\profile\FollowProfileService;
use app\modules\api\services\profile\forms\FollowProfileForm;
use app\modules\api\services\profile\forms\UnfollowProfileForm;
use app\modules\api\services\profile\UnfollowProfileService;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    protected $modelAlias = 'profile';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view'];

        return $behaviors;
    }

    /**
     * @param $username
     * @return \app\modules\api\domains\user\Profile|null
     * @throws NotFoundHttpException
     */
    public function actionView($username)
    {
        return $this->loadModel($username);
    }

    /**
     * @param $username
     * @return FollowProfileForm|bool
     * @throws NotFoundHttpException
     */
    public function actionFollow($username)
    {
        $model = $this->loadModel($username);

        $form = new FollowProfileForm([
            'username' => $username,
            'follower_id' => \Yii::$app->user->id,
            'followed_id' => $model->id,
        ]);

        if ($form->validate()) {
            $service = new FollowProfileService($form);
            if ($followedId = $service->execute()) {
                return Profile::findOne($followedId);
            }
        }

        return $form;
    }

    /**
     * @param $username
     * @return UnfollowProfileForm|bool
     * @throws NotFoundHttpException
     */
    public function actionUnfollow($username)
    {
        $model = $this->loadModel($username);

        $form = new UnfollowProfileForm([
            'username' => $username,
            'follower_id' => \Yii::$app->user->id,
            'followed_id' => $model->id,
        ]);

        if ($form->validate()) {
            $model = Follow::findOne([
                'follower_id' => \Yii::$app->user->id,
                'followed_id' => $model->id,
            ]);
            $service = new UnfollowProfileService($form, $model);
            if ($followedId = $service->execute()) {
                return Profile::findOne($followedId);
            }
        }

        return $form;
    }

    /**
     * @param $username
     * @return \app\modules\api\domains\user\Profile|null
     * @throws NotFoundHttpException
     */
    private function loadModel($username)
    {
        $model = \app\modules\api\domains\user\Profile::findOne(['username' => $username]);

        if (empty($model)) {
            throw new NotFoundHttpException('Username not found.');
        }

        return $model;
    }
}
