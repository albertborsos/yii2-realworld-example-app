<?php

namespace app\modules\api\services\article;

use app\components\Service;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\services\article\forms\FavoriteArticleForm;

/**
 * Class FavoriteArticleService
 * @package app\modules\api\services\article
 * @property FavoriteArticleForm $form
 */
class FavoriteArticleService extends Service
{

    public function execute()
    {
        $model = new Favorite();

        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->article_id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
