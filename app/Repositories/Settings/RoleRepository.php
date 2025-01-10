<?php

namespace App\Repositories\Settings;

use App\{Models\Role, Repositories\BaseRepository};

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
