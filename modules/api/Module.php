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
                    'POST login' => 'login',
                    'OPTIONS login' => 'options',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['user' => $this->id . '/auth'],
                'only' => ['index', 'update', 'options'],
                'extraPatterns' => [
                    'PUT,PATCH' => 'update',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['articles' => $this->id . '/article'],
                'only' => ['feed', 'options'],
                'patterns' => [
                    'GET,HEAD feed' => 'feed',
                    'OPTIONS feed' => 'options',
                ],
                'ruleConfig' => [
                    'class' => \yii\web\UrlRule::class,
                    'defaults' => ['isFeed' => 1],
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['articles' => $this->id . '/comment'],
                'patterns' => [
                    'POST {slug}/comments' => 'create',
                    'GET,HEAD {slug}/comments' => 'index',
                    'DELETE {slug}/comments/{id}' => 'delete',
                    '{slug}/comments/{id}' => 'options',
                    '{slug}/comments' => 'options',
                ],
                'tokens' => [
                    '{slug}' => '<slug>',
                    '{id}' => '<id:\\d[\\d,]*>',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['articles' => $this->id . '/article'],
                'except' => ['feed'],
                'extraPatterns' => [
                    // favorite
                    'POST {id}/favorite' => 'favorite',
                    'DELETE {id}/favorite' => 'unfavorite',
                    'OPTIONS {id}/favorite' => 'options',
                ],
                'tokens' => [
                    '{id}' => '<id>',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['profiles' => $this->id . '/profile'],
                'only' => ['view', 'follow', 'unfollow', 'options'],
                'extraPatterns' => [
                    'GET,HEAD {username}' => 'view',
                    'OPTIONS {username}' => 'options',

                    'POST {username}/follow' => 'follow',
                    'DELETE {username}/follow' => 'unfollow',
                    'OPTIONS {username}/follow' => 'options',
                ],
                'tokens' => [
                    '{username}' => '<username>',
                ],
            ],
            [
                'class' => UrlRule::class,
                'prefix' => $this->id,
                'controller' => ['tags' => $this->id . '/tag'],
                'only' => ['index', 'options'],
            ],
        ]);
    }
}
