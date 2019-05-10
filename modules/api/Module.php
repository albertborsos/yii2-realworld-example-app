<?php

namespace app\modules\api;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\rest\UrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = '\app\modules\api\controllers';

    public function init()
    {
        parent::init();
        // RESTful API is stateless.
        if (Yii::$app->has('user')) {
            Yii::$app->user->enableSession = false;
        }

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = '\app\modules\api\commands';
        }
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $this->registerUrlRules($app);
    }

    private function registerUrlRules(Application $app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['users' => $this->id . '/auth'],
                'extraPatterns' => [
                    'login' => 'login',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['user' => $this->id . '/auth'],
                'only' => ['index', 'update'],
                'extraPatterns' => [
                    'PUT,PATCH' => 'update',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['articles' => $this->id . '/article'],
                'except' => ['feed'],
                'extraPatterns' => [
                    'POST {id}/favorite' => 'favorite',
                    'DELETE {id}/favorite' => 'unfavorite',
                ],
                'tokens' => [
                    '{id}' => '<id>',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['articles' => $this->id . '/article'],
                'only' => ['feed'],
                'extraPatterns' => [
                    'GET,HEAD feed' => 'feed',
                ],
                'ruleConfig' => [
                    'class' => \yii\web\UrlRule::class,
                    'defaults' => ['isFeed' => 1],
                ]
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['profiles' => $this->id . '/profile'],
                'only' => ['view', 'follow', 'unfollow'],
                'extraPatterns' => [
                    'GET,HEAD {username}' => 'view',
                    'POST {username}/follow' => 'follow',
                    'DELETE {username}/follow' => 'unfollow',
                ],
                'tokens' => [
                    '{username}' => '<username>',
                ],
            ],
        ]);
    }
}
