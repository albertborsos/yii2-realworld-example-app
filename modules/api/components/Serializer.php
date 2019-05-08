<?php

namespace app\modules\api\components;

use yii\base\Arrayable;
use yii\helpers\Inflector;

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

    protected function serializeModels(array $models)
    {
        if (empty($this->alias)) {
            return parent::serializeModels($models);
        }

        return [
            Inflector::pluralize($this->alias) . 'Count' => count($models),
            Inflector::pluralize($this->alias) => parent::serializeModels($models),
        ];
    }
}
