<?php

namespace app\modules\conduit\domains\comment\query;

/**
 * This is the ActiveQuery class for [[\app\modules\conduit\domains\comment\ar\Comment]].
 *
 * @see \app\modules\conduit\domains\comment\ar\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\comment\ar\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\comment\ar\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
