<?php

namespace app\traits;

use app\domains\favorite\Favorite;

trait FavoriteClassPropertyTrait
{
    protected $favoriteClass = Favorite::class;
}
