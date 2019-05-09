<?php

namespace app\modules\api\services\article;

use app\components\Service;
use app\modules\api\domains\article\Article;
use app\modules\api\services\article\forms\UpdateArticleForm;

/**
 * Class UpdateArticleService
 * @package app\modules\api\services\article
 * @property UpdateArticleForm $form
 * @property Article $model
 */
class UpdateArticleService extends Service
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
