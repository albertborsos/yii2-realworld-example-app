<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Controller;
use app\modules\api\domains\article\Article;
use app\modules\api\domains\comment\Comment;
use app\modules\api\services\comment\CreateCommentService;
use app\modules\api\services\comment\forms\CreateCommentForm;
use app\modules\api\services\comment\forms\SearchCommentForm;
use Yii;
use yii\rest\DeleteAction;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    protected $modelAlias = 'comment';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['index'];

        return $behaviors;
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => Comment::class,
                'findModel' => function ($id) {
                    $article = $this->loadArticle(Yii::$app->request->getQueryParam('slug'));

                    $model = Comment::findOne([
                        'id' => $id,
                        'user_id' => \Yii::$app->user->id,
                        'article_id' => $article->id,
                    ]);

                    if ($model) {
                        return $model;
                    }

                    throw new NotFoundHttpException("Comment not found: $id");
                },
            ],
        ]);
    }

    /**
     * @param $slug
     * @return Comment|CreateCommentForm|null
     * @throws NotFoundHttpException
     */
    public function actionCreate($slug)
    {
        $article = $this->loadArticle($slug);

        $form = new CreateCommentForm([
            'article_id' => $article->id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($form->load(Yii::$app->request->post(), 'comment') && $form->validate()) {
            $service = new CreateCommentService($form);
            if ($commentId = $service->execute()) {
                return Comment::findOne($commentId);
            }
        }

        return $form;
    }

    /**
     * @param $slug
     * @return \yii\data\ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionIndex($slug)
    {
        $article = $this->loadArticle($slug);

        $searchModel = new SearchCommentForm([
            'article_id' => $article->id,
        ]);

        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    /**
     * @param $slug
     * @return Article
     * @throws NotFoundHttpException
     */
    private function loadArticle($slug)
    {
        $model = Article::findOne(['slug' => $slug]);

        if (empty($model)) {
            throw new NotFoundHttpException("Article not found: $slug");
        }

        return $model;
    }

    public function prepareDataProvider()
    {
        $searchModel = new SearchCommentForm();

        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
