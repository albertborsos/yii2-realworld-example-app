<?php

namespace app\modules\api\services\tag\forms;

use app\modules\conduit\components\validators\HtmlPurifierFilter;
use app\modules\conduit\domains\tag\Tag;
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
