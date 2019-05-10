<?php

namespace app\modules\api\components;

use app\modules\api\components\actions\IndexAction;

abstract class ActiveController extends \yii\rest\ActiveController
{
    use ControllerAliasTrait;
    use ControllerBehaviorsTrait;

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
        ]);
    }

    abstract public function prepareDataProvider();
}
