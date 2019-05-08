<?php

namespace app\domains\article\query;

/**
 * This is the ActiveQuery class for [[\app\domains\article\ar\ArticleTag]].
 *
 * @see \app\domains\article\ar\ArticleTag
 */
class ArticleTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\domains\article\ar\ArticleTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\article\ar\ArticleTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
