<?php

namespace app\modules\api\controllers;

use app\modules\api\components\actions\IndexAction;
use app\modules\api\components\ActiveController;
use app\modules\api\domains\article\Article;
use app\modules\api\services\article\CreateArticleService;
use app\modules\api\services\article\forms\CreateArticleForm;
use app\modules\api\services\article\forms\SearchArticleForm;
use app\modules\api\services\article\forms\UpdateArticleForm;
use app\modules\api\services\article\UpdateArticleService;
use yii\rest\ViewAction;
use yii\web\NotFoundHttpException;

class ArticleController extends ActiveController
{
    protected $modelAlias = 'article';

    public $modelClass = Article::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['index'];

        return $behaviors;
    }

    public function actions()
    {
        $actions = array_merge(parent::actions(), [
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'findModel' => function ($id) {
                    return Article::findOne(['slug' => $id]);
                },
            ],
            'feed' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
        ]);

        unset($actions['create']);
        unset($actions['update']);

        return $actions;
    }

    public function actionCreate()
    {
        $form = new CreateArticleForm([
            'user_id' => \Yii::$app->user->id,
        ]);

        if ($form->load(\Yii::$app->request->post(), 'article') && $form->validate()) {
            $service = new CreateArticleService($form);
            if ($id = $service->execute()) {
                return Article::findOne($id);
            }
        }

        return $form;
    }

    public function actionUpdate($id)
    {
        $model = Article::findOne([
            'slug' => $id,
            'user_id' => \Yii::$app->user->id,
        ]);

        if (empty($model)) {
            throw new NotFoundHttpException('Article not found.');
        }

        $form = new UpdateArticleForm($model);

        if ($form->load(\Yii::$app->request->post(), 'article') && $form->validate()) {
            $service = new UpdateArticleService($form, $model);
            if ($id = $service->execute()) {
                return Article::findOne($id);
            }
        }

        return $form;
    }

    public function prepareDataProvider()
    {
        $searchModel = new SearchArticleForm();

        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
