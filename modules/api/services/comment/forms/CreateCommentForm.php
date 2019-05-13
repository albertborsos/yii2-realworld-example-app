<?php

namespace app\modules\api\services\comment\forms;

use app\modules\conduit\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\article\Article;
use app\modules\api\domains\user\User;
use yii\base\Model;

class CreateCommentForm extends Model
{
    public $body;
    public $article_id;
    public $user_id;

    public function rules()
    {
        return [
            [['body', 'article_id', 'user_id'], HtmlPurifierFilter::class],
            [['body', 'article_id', 'user_id'], 'trim'],
            [['body', 'article_id', 'user_id'], 'default'],
            [['body', 'article_id', 'user_id'], 'required'],

            [['article_id'], 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }
}
