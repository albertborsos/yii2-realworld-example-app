<?php

namespace app\modules\conduit\domains\user\ar;

use app\modules\conduit\domains\article\Article;
use app\modules\conduit\domains\comment\Comment;
use app\modules\conduit\domains\favorite\Favorite;
use app\modules\conduit\domains\follow\Follow;
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
 *
 * @property Article[] $articles
 * @property Comment[] $comments
 * @property Favorite[] $favorites
 * @property Article[] $articles0
 * @property Follow[] $follows
 * @property Follow[] $follows0
 * @property User[] $followers
 * @property User[] $followeds
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
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany($this->articleClass, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany($this->commentClass, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany($this->favoriteClass, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getArticles0()
    {
        return $this->hasMany($this->articleClass, ['id' => 'article_id'])->viaTable('favorite', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollows()
    {
        return $this->hasMany($this->followClass, ['followed_id' => 'id'])->inverseOf('followed');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollows0()
    {
        return $this->hasMany($this->followClass, ['follower_id' => 'id'])->inverseOf('follower');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFollowers()
    {
        return $this->hasMany(static::class, ['id' => 'follower_id'])->viaTable('follow', ['followed_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFolloweds()
    {
        return $this->hasMany(static::class, ['id' => 'followed_id'])->viaTable('follow', ['follower_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\user\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\conduit\domains\user\query\UserQuery(get_called_class());
    }
}
