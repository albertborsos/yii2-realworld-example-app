<?php

namespace app\modules\conduit\domains\favorite\query;

/**
 * This is the ActiveQuery class for [[\app\modules\conduit\domains\favorite\ar\Favorite]].
 *
 * @see \app\modules\conduit\domains\favorite\ar\Favorite
 */
class FavoriteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\favorite\ar\Favorite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\favorite\ar\Favorite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
