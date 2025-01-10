<?php

namespace App\Repositories\Settings;

use App\{Models\Permission, Repositories\BaseRepository};

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
