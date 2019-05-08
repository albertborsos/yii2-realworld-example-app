<?php

namespace app\modules\api\services\tag\forms;

use app\components\validators\HtmlPurifierFilter;
use app\domains\tag\Tag;
use yii\base\Model;

class CreateTagForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], HtmlPurifierFilter::class],
            [['name'], 'trim'],
            [['name'], 'default'],
            [['name'], 'required'],

            [['name'], 'unique', 'targetClass' => Tag::class, 'targetAttribute' => 'name'],
        ];
    }
}
