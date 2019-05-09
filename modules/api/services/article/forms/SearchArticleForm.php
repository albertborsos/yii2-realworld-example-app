<?php

namespace app\modules\api\services\article\forms;

use app\modules\api\domains\article\Article;
use app\modules\api\domains\follow\Follow;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchArticleForm extends Model
{
    public $id;
    public $user_id;
    public $slug;
    public $title;
    public $description;
    public $body;
    public $createdAt;
    public $createdBy;
    public $updatedAt;
    public $updatedBy;
    public $tagList;
    public $favorited;
    public $favoritesCount;
    public $author;
    public $tag;

    public $isFeed;

    public function rules()
    {
        return [
            [['id', 'user_id', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy'], 'integer'],
            [['author', 'favorited', 'tag'], 'string'],
            [['isFeed'], 'boolean'],
            [['slug', 'title', 'description', 'body'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->createdAt,
            'created_by' => $this->createdBy,
            'updated_at' => $this->updatedAt,
            'updated_by' => $this->updatedBy,
        ]);

        if ($this->author) {
            $query->joinWith(['author author']);
            $query->andWhere(['author.username' => $this->author]);
        }

        if ($this->tag) {
            $query->joinWith(['tags tag']);
            $query->andWhere(['tag.name' => $this->tag]);
        }

        if ($this->favorited) {
            $query->joinWith([
                'favorites',
                'favorites.user favoritesUser',
            ]);
            $query->andWhere(['favoritesUser.username' => $this->favorited]);
        }

        if ($this->isFeed && \Yii::$app->user->isGuest === false) {
            // only those articles which authors are followed by the user
            $followedAuthorIds = Follow::find()->where(['follower_id' => \Yii::$app->user->id])->select('followed_id')->column();
            $query->andFilterWhere(['user_id' => $followedAuthorIds]);
        }

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
