<?php

namespace App\Repositories\Settings;

use App\{Models\Currency, Repositories\BaseRepository};

class CurrencyRepository extends BaseRepository
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
