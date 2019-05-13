<?php

namespace app\modules\conduit\domains\article\ar;

use app\modules\conduit\domains\tag\Tag;
use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $article_id
 * @property int $tag_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Article $article
 * @property Tag $tag
 */
abstract class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['article_id', 'tag_id'], 'unique', 'targetAttribute' => ['article_id', 'tag_id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('article-tag', 'Article ID'),
            'tag_id' => Yii::t('article-tag', 'Tag ID'),
            'created_at' => Yii::t('article-tag', 'Created At'),
            'created_by' => Yii::t('article-tag', 'Created By'),
            'updated_at' => Yii::t('article-tag', 'Updated At'),
            'updated_by' => Yii::t('article-tag', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne($this->articleClass, ['id' => 'article_id'])->inverseOf('articleTags');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne($this->tagClass, ['id' => 'tag_id'])->inverseOf('articleTags');
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\conduit\domains\article\query\ArticleTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\conduit\domains\article\query\ArticleTagQuery(get_called_class());
    }
}
