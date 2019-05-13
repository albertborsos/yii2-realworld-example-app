<?php

namespace app\modules\conduit\domains\article\ar;

use app\modules\conduit\domains\comment\Comment;
use app\modules\conduit\domains\favorite\Favorite;
use app\modules\conduit\domains\tag\Tag;
use app\modules\conduit\domains\user\User;
use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property User $user
 * @property ArticleTag[] $articleTags
 * @property Tag[] $tags
 * @property Comment[] $comments
 * @property Favorite[] $favorites
 * @property User[] $users
 */
abstract class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['body'], 'string'],
            [['slug', 'title', 'description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('article', 'ID'),
            'user_id' => Yii::t('article', 'User ID'),
            'slug' => Yii::t('article', 'Slug'),
            'title' => Yii::t('article', 'Title'),
            'description' => Yii::t('article', 'Description'),
            'body' => Yii::t('article', 'Body'),
            'created_at' => Yii::t('article', 'Created At'),
            'created_by' => Yii::t('article', 'Created By'),
            'updated_at' => Yii::t('article', 'Updated At'),
            'updated_by' => Yii::t('article', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->userClass, ['id' => 'user_id'])->inverseOf('articles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany($this->articleTagClass, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany($this->tagClass, ['id' => 'tag_id'])->viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany($this->commentClass, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany($this->favoriteClass, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany($this->userClass, ['id' => 'user_id'])->viaTable('favorite', ['article_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\article\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\conduit\domains\article\query\ArticleQuery(get_called_class());
    }
}
