<?php

namespace app\domains\comment\ar;

use app\domains\article\Article;
use app\domains\user\User;
use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $body
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Article $article
 * @property User $user
 */
abstract class Comment extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['body'], 'string'],
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
            'id' => Yii::t('comment', 'ID'),
            'user_id' => Yii::t('comment', 'User ID'),
            'article_id' => Yii::t('comment', 'Article ID'),
            'body' => Yii::t('comment', 'Body'),
            'created_at' => Yii::t('comment', 'Created At'),
            'created_by' => Yii::t('comment', 'Created By'),
            'updated_at' => Yii::t('comment', 'Updated At'),
            'updated_by' => Yii::t('comment', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne($this->articleClass, ['id' => 'article_id'])->inverseOf('comments');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->userClass, ['id' => 'user_id'])->inverseOf('comments');
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\comment\query\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\domains\comment\query\CommentQuery(get_called_class());
    }
}
