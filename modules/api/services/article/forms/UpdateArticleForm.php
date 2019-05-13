<?php

namespace app\modules\api\services\article\forms;

use app\modules\conduit\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\article\Article;
use yii\base\Model;

class UpdateArticleForm extends Model
{
    public $title;
    public $description;
    public $body;

    public function __construct(Article $model, array $config = [])
    {
        parent::__construct($config);
        $this->title = $model->title;
        $this->description = $model->description;
        $this->body = $model->body;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'body'], HtmlPurifierFilter::class],
            [['title', 'description', 'body'], 'trim'],
            [['title', 'description', 'body'], 'default'],
            [['title', 'description', 'body'], 'required'],
        ];
    }
}