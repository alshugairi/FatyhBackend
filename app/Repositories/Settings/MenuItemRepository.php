<?php

namespace App\Repositories\Settings;

use App\{Models\MenuItem, Repositories\BaseRepository};

class MenuItemRepository extends BaseRepository
{
    public function __construct(MenuItem $model)
    {
        parent::__construct($model);
    }
}
