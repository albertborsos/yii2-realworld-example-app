<?php

namespace app\domains\user\query;

/**
 * This is the ActiveQuery class for [[\app\domains\user\User]].
 *
 * @see \app\domains\user\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\domains\user\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\user\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
