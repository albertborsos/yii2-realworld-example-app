<?php

namespace app\modules\api\services\profile;

use app\components\Service;
use app\modules\api\domains\follow\Follow;
use app\modules\api\services\profile\forms\FollowProfileForm;

/**
 * Class FollowProfileService
 * @package app\modules\api\services\profile
 * @property FollowProfileForm $form
 * @property Follow $model
 */
class UnfollowProfileService extends Service
{
    public function execute()
    {
        if ($this->model->delete()) {
            return $this->model->followed_id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
