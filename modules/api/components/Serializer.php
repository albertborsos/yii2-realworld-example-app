<?php

namespace app\modules\api\components;

use yii\base\Arrayable;
use yii\helpers\Inflector;

class Serializer extends \yii\rest\Serializer
{
    public $alias;

    public function serialize($data)
    {
        $serializedData = parent::serialize($data); // TODO: Change the autogenerated stub

        if (!empty($this->alias) && is_array($data) && count($data) > 1 && $data === $serializedData) {
            return [Inflector::pluralize($this->alias) => $serializedData];
        }

        return $serializedData;
    }

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

    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[$name][] = $message;
        }

        return ['errors' => $result];
    }
}
