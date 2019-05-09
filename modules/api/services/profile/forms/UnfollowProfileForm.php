<?php

namespace app\modules\api\services\profile\forms;

use app\components\validators\HtmlPurifierFilter;
use app\modules\api\domains\follow\Follow;
use app\modules\api\domains\user\Profile;
use Yii;
use yii\base\Model;
use yii\validators\ExistValidator;

class UnfollowProfileForm extends Model
{
    public $username;

    public $followed_id;
    public $follower_id;

    public function rules()
    {
        return [
            [['followed_id', 'follower_id', 'username'], HtmlPurifierFilter::class],
            [['followed_id', 'follower_id', 'username'], 'trim'],
            [['followed_id', 'follower_id', 'username'], 'default'],
            [['followed_id', 'follower_id'], 'required'],

            [['followed_id', 'follower_id'], 'integer'],

            [['followed_id'], 'exist', 'targetClass' => Profile::class, 'targetAttribute' => 'id'],
            [['follower_id'], 'exist', 'targetClass' => Profile::class, 'targetAttribute' => 'id'],

            [['username'], 'isFollowing'],
        ];
    }

    public function isFollowing($attribute)
    {
        $validator = new ExistValidator([
            'attributes'  => ['followed_id', 'follower_id'],
            'targetClass' => Follow::class,
            'targetAttribute' => ['followed_id', 'follower_id'],
        ]);

        $model = clone($this);
        $validator->validateAttributes($model);

        if ($model->hasErrors()) {
            $this->addError($attribute, Yii::t('profile', 'You are not following this profile!'));
        }
    }
}
