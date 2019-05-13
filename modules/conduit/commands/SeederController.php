<?php

namespace app\modules\conduit\commands;

use app\modules\conduit\models\Seeder;
use yii\console\Controller;

class SeederController extends Controller
{
    public function actionIndex()
    {
        return Seeder::run();
    }
}
