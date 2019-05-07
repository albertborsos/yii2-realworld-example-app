<?php

namespace app\domains\user\ar;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $bio
 * @property string $image
 * @property string $token
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class User extends \yii\db\ActiveRecord
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
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['username', 'email', 'password', 'image'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'bio' => Yii::t('user', 'Bio'),
            'image' => Yii::t('user', 'Image'),
            'token' => Yii::t('user', 'Token'),
            'created_at' => Yii::t('user', 'Created At'),
            'created_by' => Yii::t('user', 'Created By'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'updated_by' => Yii::t('user', 'Updated By'),
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
