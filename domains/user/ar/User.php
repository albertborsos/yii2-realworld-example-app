<?php

namespace app\domains\user\ar;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $bio
 * @property string $image
 * @property string $token
 */
abstract class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bio'], 'string'],
            [['email', 'username', 'image', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'email' => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'Username'),
            'bio' => Yii::t('user', 'Bio'),
            'image' => Yii::t('user', 'Image'),
            'token' => Yii::t('user', 'Token'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\user\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\domains\user\query\UserQuery(get_called_class());
    }
}
