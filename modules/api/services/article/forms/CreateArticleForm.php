<?php

namespace app\modules\api\services\article\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\user\User;
use yii\base\Model;

class CreateArticleForm extends Model
{
    public $title;
    public $description;
    public $body;
    public $tagList;

    public $user_id;

    public function rules()
    {
        return [
            [['title', 'description', 'body'], HtmlPurifierFilter::class],
            [['title', 'description', 'body'], 'trim'],
            [['title', 'description', 'body'], 'default'],
            [['title', 'description', 'body'], 'required'],

            [['tagList'], 'each', 'rule' => [HtmlPurifierFilter::class]],
            [['tagList'], 'each', 'rule' => ['trim']],
            [['tagList'], 'each', 'rule' => ['default']],
            [['tagList'], 'each', 'rule' => ['string']],

            [['user_id'], 'required'],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }
}
