<?php

namespace app\modules\api\services\tag;

use app\modules\conduit\components\Service;
use app\modules\conduit\domains\tag\Tag;
use app\modules\api\services\tag\forms\CreateTagForm;

/**
 * Class CreateTagService
 * @package app\modules\api\services\tag
 * @property CreateTagForm $form
 */
class CreateTagService extends Service
{
    public function execute()
    {
        $model = new Tag();

        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
