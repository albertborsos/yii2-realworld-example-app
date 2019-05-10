<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Controller;
use app\modules\api\domains\tag\Tag;

class TagController extends Controller
{
    protected $modelAlias = 'tag';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['index'];

        return $behaviors;
    }

    public function actionIndex()
    {
        return Tag::find()->select('name')->column();
    }
}
