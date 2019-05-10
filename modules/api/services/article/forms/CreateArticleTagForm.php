<?php

namespace app\modules\api\services\article\forms;

use app\components\validators\HtmlPurifierFilter;
use app\domains\article\Article;
use app\domains\article\ArticleTag;
use app\domains\tag\Tag;
use yii\base\Model;

class CreateArticleTagForm extends Model
{
    public $article_id;
    public $tag_id;

    public function rules()
    {
        return [
            [['article_id', 'tag_id'], HtmlPurifierFilter::class],
            [['article_id', 'tag_id'], 'trim'],
            [['article_id', 'tag_id'], 'default'],
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],

            [['article_id'], 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
            [['tag_id'], 'exist', 'targetClass' => Tag::class, 'targetAttribute' => 'id'],

            [['article_id', 'tag_id'], 'unique', 'targetClass' => ArticleTag::class, 'targetAttribute' => ['article_id', 'tag_id']],
        ];
    }
}
