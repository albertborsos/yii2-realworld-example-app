<?php

namespace app\commands;

use app\models\Seeder;
use yii\console\Controller;

class SeederController extends Controller
{
    public function actionIndex()
    {
        return Seeder::run();
    }
}
