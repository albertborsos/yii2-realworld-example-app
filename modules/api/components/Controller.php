<?php

namespace app\modules\api\components;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class Controller extends \yii\rest\Controller
{
    protected $modelAlias;

    public function init()
    {
        if ($this->modelAlias) {
            $this->serializer = ['class' => Serializer::class, 'alias' => $this->modelAlias];
        }
        parent::init();
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'pattern' => '/^Token\s+(.*?)$/',
            ],
        ]);
    }
}
