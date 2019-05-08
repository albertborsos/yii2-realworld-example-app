<?php

namespace app\domains\comment\query;

/**
 * This is the ActiveQuery class for [[\app\domains\comment\ar\Comment]].
 *
 * @see \app\domains\comment\ar\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\domains\comment\ar\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\comment\ar\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
