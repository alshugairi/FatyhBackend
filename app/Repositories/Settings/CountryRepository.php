<?php

namespace App\Repositories\Settings;

use App\{Models\Country, Repositories\BaseRepository};

class CountryRepository extends BaseRepository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
