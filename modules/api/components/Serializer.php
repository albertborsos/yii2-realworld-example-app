<?php

namespace app\modules\api\components;

class Serializer extends \yii\rest\Serializer
{
    public $alias;

    protected function serializeModel($model)
    {
        if (empty($this->alias)) {
            return parent::serializeModel($model);
        }

        return [$this->alias => parent::serializeModel($model)];
    }
}
