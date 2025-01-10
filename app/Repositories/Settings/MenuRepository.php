<?php

namespace App\Repositories\Settings;

use App\{Models\Menu, Repositories\BaseRepository};

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }
}
