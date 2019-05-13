<?php

namespace app\modules\api\services\article;

use app\modules\conduit\components\Service;
use app\modules\api\domains\article\Article;
use app\modules\api\services\article\forms\CreateArticleForm;
use app\modules\api\services\article\forms\CreateArticleTagForm;
use app\modules\conduit\repositories\TagRepository;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * Class CreateArticleService
 * @package app\modules\api\services\article
 * @property CreateArticleForm $form
 */
class CreateArticleService extends Service
{
    public function execute()
    {
        $model = new Article();

        $model->setAttributes($this->form->attributes);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($model->save()) {
                $this->assignTags($model->id, $this->form->tagList);

                $transaction->commit();

                return $model->id;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }

    /**
     * @param int $articleId
     * @param array $tagList
     * @return bool
     * @throws Exception
     */
    private function assignTags(int $articleId, array $tagList)
    {
        foreach ($tagList as $tagName) {
            $tag = TagRepository::findOrCreateByName($tagName);

            $form = new CreateArticleTagForm([
                'article_id' => $articleId,
                'tag_id' => $tag->id,
            ]);

            if ($form->validate()) {
                $service = new CreateArticleTagService($form);
                if ($id = $service->execute()) {
                    continue;
                }
            }

            throw new Exception(Json::encode($form->getErrors()));
        }

        return true;
    }

}