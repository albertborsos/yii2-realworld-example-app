<?php

namespace app\domains\follow\ar;

use app\domains\user\User;
use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property int $follower_id
 * @property int $followed_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property User $followed
 * @property User $follower
 */
abstract class Follow extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'follow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['follower_id', 'followed_id'], 'required'],
            [['follower_id', 'followed_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['follower_id', 'followed_id'], 'unique', 'targetAttribute' => ['follower_id', 'followed_id']],
            [['followed_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['followed_id' => 'id']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['follower_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'follower_id' => Yii::t('follow', 'Follower ID'),
            'followed_id' => Yii::t('follow', 'Followed ID'),
            'created_at' => Yii::t('follow', 'Created At'),
            'created_by' => Yii::t('follow', 'Created By'),
            'updated_at' => Yii::t('follow', 'Updated At'),
            'updated_by' => Yii::t('follow', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowed()
    {
        return $this->hasOne($this->userClass, ['id' => 'followed_id'])->inverseOf('follows');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne($this->userClass, ['id' => 'follower_id'])->inverseOf('follows0');
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\follow\query\FollowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\domains\follow\query\FollowQuery(get_called_class());
    }
}
