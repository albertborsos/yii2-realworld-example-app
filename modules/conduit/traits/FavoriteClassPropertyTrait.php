<?php

namespace app\modules\conduit\traits;

use app\modules\conduit\domains\favorite\Favorite;

trait FavoriteClassPropertyTrait
{
    protected $favoriteClass = Favorite::class;
}
