<?php

namespace app\modules\conduit\domains\tag\query;

/**
 * This is the ActiveQuery class for [[\app\modules\conduit\domains\tag\ar\Tag]].
 *
 * @see \app\modules\conduit\domains\tag\ar\Tag
 */
class TagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\tag\ar\Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\tag\ar\Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
