<?php

namespace app\modules\api\components;

use yii\rest\OptionsAction;

class Controller extends \yii\rest\Controller
{
    use ControllerAliasTrait;
    use ControllerBehaviorsTrait;

    public function actions()
    {
        return array_merge(parent::actions(), [
            'options' => OptionsAction::class,
        ]);
    }
}
