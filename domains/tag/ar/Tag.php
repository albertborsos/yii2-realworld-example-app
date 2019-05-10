<?php

namespace app\domains\tag\ar;

use app\domains\article\Article;
use app\domains\article\ArticleTag;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property ArticleTag[] $articleTags
 * @property Article[] $articles
 */
abstract class Tag extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tag', 'ID'),
            'name' => Yii::t('tag', 'Name'),
            'created_at' => Yii::t('tag', 'Created At'),
            'created_by' => Yii::t('tag', 'Created By'),
            'updated_at' => Yii::t('tag', 'Updated At'),
            'updated_by' => Yii::t('tag', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany($this->articleTagClass, ['tag_id' => 'id'])->inverseOf('tag');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getArticles()
    {
        return $this->hasMany($this->articleClass, ['id' => 'article_id'])->viaTable('article_tag', ['tag_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\domains\tag\query\TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\domains\tag\query\TagQuery(get_called_class());
    }
}
