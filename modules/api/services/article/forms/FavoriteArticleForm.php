<?php

namespace app\modules\api\services\article\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\article\Article;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\domains\user\User;
use Yii;
use yii\base\Model;
use yii\validators\UniqueValidator;

class FavoriteArticleForm extends Model
{
    public $article_id;
    public $user_id;

    public $article;

    public function rules()
    {
        return [
            [['article_id', 'user_id'], HtmlPurifierFilter::class],
            [['article_id', 'user_id'], 'trim'],
            [['article_id', 'user_id'], 'default'],
            [['article_id', 'user_id'], 'required'],

            [['article_id'], 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],

            [['article'], 'isNotFavorited', 'skipOnEmpty' => false],
        ];
    }

    public function isNotFavorited($attribute)
    {
        $validator = new UniqueValidator([
            'attributes'  => ['article_id', 'user_id'],
            'targetClass' => Favorite::class,
            'targetAttribute' => ['article_id', 'user_id'],
        ]);

        $model = clone($this);
        $validator->validateAttributes($model);

        if ($model->hasErrors()) {
            $this->addError($attribute, Yii::t('article', 'You are already favorited this article!'));
        }
    }
}
