<?php

namespace app\modules\api\services\user;

use app\modules\conduit\components\Service;

class UpdateUserService extends Service
{
    public function execute()
    {
        $this->model->setAttributes($this->form->attributes);

        if ($this->model->save()) {
            return $this->model->id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
