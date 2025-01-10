<?php

namespace App\Repositories\Settings;

use App\{Models\City, Repositories\BaseRepository};

class CityRepository extends BaseRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
