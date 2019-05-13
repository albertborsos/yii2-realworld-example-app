<?php

namespace app\modules\api\services\profile;

use app\modules\conduit\components\Service;
use app\modules\api\domains\follow\Follow;
use app\modules\api\services\profile\forms\FollowProfileForm;

/**
 * Class FollowProfileService
 * @package app\modules\api\services\profile
 * @property FollowProfileForm $form
 */
class FollowProfileService extends Service
{
    public function execute()
    {
        $model = new Follow();
        $model->setAttributes($this->form->attributes);

        if ($model->save()) {
            return $model->followed_id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
