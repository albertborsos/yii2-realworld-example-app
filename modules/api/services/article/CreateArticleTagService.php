<?php

namespace app\modules\api\services\article;

use app\components\Service;
use app\domains\article\ArticleTag;
use app\modules\api\services\article\forms\CreateArticleTagForm;

/**
 * Class CreateArticleTagService
 * @package app\modules\api\services\article
 * @property CreateArticleTagForm $form
 */
class CreateArticleTagService extends Service
{
    public function execute()
    {
        $model = new ArticleTag();
        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->primaryKey;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
