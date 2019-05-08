<?php

namespace app\modules\api\domains\article;

use app\modules\api\domains\comment\Comment;
use app\modules\api\domains\favorite\Favorite;
use app\modules\api\domains\tag\Tag;
use app\modules\api\domains\user\Profile;
use app\modules\api\domains\user\User;
use Carbon\Carbon;
use Yii;

class Article extends \app\domains\article\Article
{
    protected $userClass = Profile::class;
    protected $articleTagClass = ArticleTag::class;
    protected $commentClass = Comment::class;
    protected $tagClass = Tag::class;
    protected $favoriteClass = Favorite::class;

    public function fields()
    {
        return [
            'slug',
            'title',
            'description',
            'body',
            'tagList',
            'createdAt' => function () {
                return (new Carbon($this->created_at))->copy()->utc()->rawFormat('Y-m-d\TH:i:s.u\Z');
            },
            'updatedAt' => function () {
                return (new Carbon($this->updated_at))->copy()->utc()->rawFormat('Y-m-d\TH:i:s.u\Z');
            },
            'favorited',
            'favoritesCount',
            'author',
        ];
    }

    /**
     * @return bool
     */
    public function getFavorited()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return $this->getFavorites()->where(['user_id' => Yii::$app->user->id])->exists();
    }

    /**
     * @return int|string
     */
    public function getFavoritesCount(): int
    {
        return Favorite::find()->where(['article_id' => $this->id])->count();
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getTagList()
    {
        return $this->getTags()->select('name')->column();
    }
}
