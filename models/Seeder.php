<?php

namespace app\models;

use app\modules\api\services\article\CreateArticleService;
use app\modules\api\services\article\FavoriteArticleService;
use app\modules\api\services\article\forms\CreateArticleForm;
use app\modules\api\services\article\forms\FavoriteArticleForm;
use app\modules\api\services\comment\CreateCommentService;
use app\modules\api\services\comment\forms\CreateCommentForm;
use app\modules\api\services\profile\FollowProfileService;
use app\modules\api\services\profile\forms\FollowProfileForm;
use app\modules\api\services\tag\CreateTagService;
use app\modules\api\services\tag\forms\CreateTagForm;
use app\modules\api\services\user\forms\RegisterUserForm;
use app\modules\api\services\user\RegisterUserService;
use Faker\Factory;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Seeder extends Component
{
    /**
     * Total number of users.
     *
     * @var int
     */
    protected $totalUsers = 25;
    /**
     * Total number of tags.
     *
     * @var int
     */
    protected $totalTags = 10;
    /**
     * Percentage of users with articles.
     *
     * @var float Value should be between 0 - 1.0
     */
    protected $userWithArticleRatio = 0.8;
    /**
     * Maximum articles that can be created by a user.
     *
     * @var int
     */
    protected $maxArticlesByUser = 15;
    /**
     * Maximum tags that can be attached to an article.
     *
     * @var int
     */
    protected $maxArticleTags = 3;
    /**
     * Maximum number of comments that can be added to an article.
     *
     * @var int
     */
    protected $maxCommentsInArticle = 10;
    /**
     * Percentage of users with favorites.
     *
     * @var float Value should be between 0 - 1.0
     */
    protected $usersWithFavoritesRatio = 0.75;
    /**
     * Percentage of users with following.
     *
     * @var float Value should be between 0 - 1.0
     */
    protected $usersWithFollowingRatio = 0.75;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function init()
    {
        parent::init();
        $this->faker = Factory::create();
    }

    public static function run()
    {
        $model = new static();
        $model->seed();
    }

    /**
     * @throws Exception
     */
    private function seed()
    {
        $users = $this->generateUsers();
        $maxUserId = max(array_keys(ArrayHelper::map($users, 'id', 'id')));
        $this->generateArticles($users, $maxUserId);
        $this->generateFollows($users, $maxUserId);
    }

    /**
     * @return \app\modules\api\domains\user\User[]
     * @throws Exception
     */
    private function generateUsers()
    {
        for ($i = 0; $i < $this->totalUsers; $i++) {
            $form = new RegisterUserForm([
                'username' => $this->faker->userName,
                'email' => $this->faker->email,
                'password' => $this->faker->word,
            ]);

            if ($form->validate()) {
                $service = new RegisterUserService($form);
                if ($userId = $service->execute()) {
                    continue;
                }
            }

            throw new Exception(Json::errorSummary($form));
        }

        return \app\domains\user\User::find()->all();
    }

    /**
     * @param $users
     * @param $maxUserId
     */
    private function generateArticles($users, $maxUserId)
    {
        foreach ($users as $user) {
            if ($this->faker->boolean($this->userWithArticleRatio * 100) === false) {
                continue;
            }

            for ($i = 0; $i < $this->faker->numberBetween(1, $this->maxArticlesByUser); $i++) {
                $form = new CreateArticleForm([
                    'title' => $this->faker->sentence,
                    'description' => $this->faker->text(),
                    'body' => $this->faker->paragraph(10),
                    'tagList' => $this->faker->words(3),
                    'user_id' => $user->id,
                ]);

                if ($form->validate()) {
                    $service = new CreateArticleService($form);
                    if ($articleId = $service->execute()) {
                        $this->generateComments($articleId, $maxUserId);
                        $this->generateFavorites($articleId, $maxUserId);
                        continue;
                    }
                }
            }
        }
    }

    /**
     * @param $articleId
     * @param $maxUserId
     */
    private function generateComments($articleId, $maxUserId)
    {
        for ($i = 0; $i < $this->faker->numberBetween(0, $this->maxCommentsInArticle); $i++) {
            $form = new CreateCommentForm([
                'user_id' => $this->faker->numberBetween($maxUserId - $this->totalUsers, $maxUserId),
                'article_id' => $articleId,
                'body' => $this->faker->paragraph(3),
            ]);

            if ($form->validate()) {
                $service = new CreateCommentService($form);
                if ($service->execute()) {
                    continue;
                }
            }
        }
    }

    /**
     * @param $articleId
     * @param $maxUserId
     */
    private function generateFavorites($articleId, $maxUserId)
    {
        if ($this->faker->boolean($this->usersWithFavoritesRatio * 100) === false) {
            return;
        }

        for ($i = 0; $i < $this->faker->numberBetween(0, 10); $i++) {
            $form = new FavoriteArticleForm([
                'user_id' => $this->faker->numberBetween($maxUserId - $this->totalUsers, $maxUserId),
                'article_id' => $articleId,
            ]);

            if ($form->validate()) {
                $service = new FavoriteArticleService($form);
                if ($service->execute()) {
                    continue;
                }
            }
        }
    }

    private function generateFollows($users, $maxUserId)
    {
        foreach ($users as $user) {
            if ($this->faker->boolean($this->usersWithFollowingRatio * 100) === false) {
                continue;
            }

            $form = new FollowProfileForm([
                'follower_id' => $user->id,
                'followed_id' => $this->faker->numberBetween($maxUserId - $this->totalUsers, $maxUserId),
            ]);

            if ($form->validate()) {
                $service = new FollowProfileService($form);
                if ($service->execute()) {
                    continue;
                }
            }
        }
    }
}
