<?php

namespace app\modules\api\controllers;

use app\modules\api\components\ActiveController;
use app\modules\api\domains\article\Article;
use app\modules\api\services\article\CreateArticleService;
use app\modules\api\services\article\forms\CreateArticleForm;
use app\modules\api\services\article\forms\SearchArticleForm;

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
        $actions = parent::actions();

        unset($actions['create']);

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

    public function prepareDataProvider()
    {
        $searchModel = new SearchArticleForm();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
