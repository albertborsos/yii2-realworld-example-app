<?php

namespace app\modules\conduit\repositories;

use app\modules\conduit\domains\tag\Tag;
use app\modules\api\services\tag\CreateTagService;
use app\modules\api\services\tag\forms\CreateTagForm;
use yii\base\Component;
use yii\base\Exception;

class TagRepository extends Component
{
    /**
     * @param $name
     * @return Tag
     * @throws Exception
     */
    public static function findOrCreateByName($name)
    {
        $model = Tag::findOne(['name' => $name]);

        if (!empty($model)) {
            return $model;
        }

        $form = new CreateTagForm(['name' => $name]);
        if ($form->validate()) {
            $service = new CreateTagService($form);
            if ($id = $service->execute()) {
                return Tag::findOne($id);
            }
        }

        throw new Exception($form->getFirstError('name'));
    }
}
