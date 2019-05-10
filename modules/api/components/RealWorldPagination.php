<?php

namespace app\modules\api\components;

use yii\data\Pagination;

class RealWorldPagination extends Pagination
{
    public $pageSizeParam = 'limit';

    public $defaultPageSize = 20;

    public $pageSizeLimit = [0, 20];
}
