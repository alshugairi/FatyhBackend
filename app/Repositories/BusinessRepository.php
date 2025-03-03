<?php

namespace App\Repositories;

use App\Models\Business;

class BusinessRepository extends BaseRepository
{
    public function __construct(Business $model)
    {
        parent::__construct($model);
    }
}
