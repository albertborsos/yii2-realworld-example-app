<?php

namespace app\modules\api\services\article;

use app\modules\conduit\components\Service;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\services\article\forms\FavoriteArticleForm;

/**
 * Class FavoriteArticleService
 * @package app\modules\api\services\article
 * @property FavoriteArticleForm $form
 * @property Favorite $model
 */
class UnfavoriteArticleService extends Service
{

    public function execute()
    {
        if ($this->model->delete()) {
            return $this->model->article_id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
