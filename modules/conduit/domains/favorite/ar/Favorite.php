<?php

namespace app\modules\conduit\domains\favorite\ar;

use app\modules\conduit\domains\article\Article;
use app\modules\conduit\domains\user\User;
use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property int $user_id
 * @property int $article_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Article $article
 * @property User $user
 */
abstract class Favorite extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id'], 'required'],
            [['user_id', 'article_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['user_id', 'article_id'], 'unique', 'targetAttribute' => ['user_id', 'article_id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('favorite', 'User ID'),
            'article_id' => Yii::t('favorite', 'Article ID'),
            'created_at' => Yii::t('favorite', 'Created At'),
            'created_by' => Yii::t('favorite', 'Created By'),
            'updated_at' => Yii::t('favorite', 'Updated At'),
            'updated_by' => Yii::t('favorite', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne($this->articleClass, ['id' => 'article_id'])->inverseOf('favorites');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->userClass, ['id' => 'user_id'])->inverseOf('favorites');
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\favorite\query\FavoriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\conduit\domains\favorite\query\FavoriteQuery(get_called_class());
    }
}
