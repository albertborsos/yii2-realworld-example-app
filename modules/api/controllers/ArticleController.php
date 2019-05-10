<?php

namespace app\modules\api\controllers;

use app\modules\api\components\actions\IndexAction;
use app\modules\api\components\ActiveController;
use app\modules\api\domains\article\Article;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\services\article\CreateArticleService;
use app\modules\api\services\article\FavoriteArticleService;
use app\modules\api\services\article\forms\CreateArticleForm;
use app\modules\api\services\article\forms\FavoriteArticleForm;
use app\modules\api\services\article\forms\SearchArticleForm;
use app\modules\api\services\article\forms\UnfavoriteArticleForm;
use app\modules\api\services\article\forms\UpdateArticleForm;
use app\modules\api\services\article\UnfavoriteArticleService;
use app\modules\api\services\article\UpdateArticleService;
use Yii;
use yii\rest\DeleteAction;
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
                    $model = Article::findOne([
                        'slug' => $id,
                    ]);

                    if ($model) {
                        return $model;
                    }

                    throw new NotFoundHttpException("Object not found: $id");
                },
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'findModel' => function ($id) {
                    $model = Article::findOne([
                        'slug' => $id,
                        'user_id' => \Yii::$app->user->id,
                    ]);

                    if ($model) {
                        return $model;
                    }

                    throw new NotFoundHttpException("Object not found: $id");
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

    /**
     * @return Article|CreateArticleForm|null
     */
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

    /**
     * @param $id
     * @return Article|UpdateArticleForm|null
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Article::findOne([
            'slug' => $id,
            'user_id' => \Yii::$app->user->id,
        ]);

        if (empty($model)) {
            throw new NotFoundHttpException("Object not found: $id");
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

    /**
     * @param $id
     * @return Article|FavoriteArticleForm|null
     * @throws NotFoundHttpException
     */
    public function actionFavorite($id)
    {
        $model = Article::findOne([
            'slug' => $id,
        ]);

        if (empty($model)) {
            throw new NotFoundHttpException("Object not found: $id");
        }

        $form = new FavoriteArticleForm([
            'article_id' => $model->id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($form->validate()) {
            $service = new FavoriteArticleService($form);
            if ($id = $service->execute()) {
                return Article::findOne($id);
            }
        }

        return $form;
    }

    /**
     * @param $id
     * @return Article|FavoriteArticleForm|null
     * @throws NotFoundHttpException
     */
    public function actionUnfavorite($id)
    {
        $model = Article::findOne([
            'slug' => $id,
        ]);

        if (empty($model)) {
            throw new NotFoundHttpException("Object not found: $id");
        }

        $form = new UnfavoriteArticleForm([
            'article_id' => $model->id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($form->validate()) {
            $model = Favorite::findOne([
                'article_id' => $model->id,
                'user_id' => \Yii::$app->user->id,
            ]);
            $service = new UnfavoriteArticleService($form, $model);
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
