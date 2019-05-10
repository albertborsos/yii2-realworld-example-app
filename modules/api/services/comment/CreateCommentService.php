<?php

namespace app\modules\api\services\comment;

use app\components\Service;
use app\modules\api\domains\comment\Comment;

class CreateCommentService extends Service
{
    public function execute()
    {
        $model = new Comment();

        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
