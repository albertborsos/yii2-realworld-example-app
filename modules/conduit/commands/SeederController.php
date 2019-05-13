<?php

namespace app\modules\conduit\commands;

use app\models\Seeder;
use yii\console\Controller;

class SeederController extends Controller
{
    public function actionIndex()
    {
        return Seeder::run();
    }
}
