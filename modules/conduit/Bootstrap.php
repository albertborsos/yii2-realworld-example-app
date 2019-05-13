<?php

namespace app\modules\conduit;

use yii\base\Application;
use yii\console\controllers\MigrateController;

class Bootstrap
{
    public static function setConfig(Application $app)
    {
        static::setConsoleConfig($app);
    }

    protected static function setConsoleConfig(Application $app)
    {
        if (!$app instanceof \yii\console\Application) {
            return;
        }

        static::addMigrationPath($app);
    }

    /**
     * @param Application $app
     */
    protected static function addMigrationPath(Application $app): void
    {
        if (!isset($app->controllerMap['migrate']['class'])) {
            $app->controllerMap['migrate']['class'] = MigrateController::class;
        }
        $app->controllerMap['migrate']['migrationPath'][] = '@app/modules/conduit/migrations';
    }
}
