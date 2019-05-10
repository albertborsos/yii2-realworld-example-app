<?php

namespace app\domains\follow\query;

/**
 * This is the ActiveQuery class for [[\app\domains\follow\ar\Follow]].
 *
 * @see \app\domains\follow\ar\Follow
 */
class FollowQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\domains\follow\ar\Follow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\follow\ar\Follow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
