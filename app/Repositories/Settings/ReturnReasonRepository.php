<?php

namespace App\Repositories\Settings;

use App\{Models\ReturnReason, Repositories\BaseRepository};

class ReturnReasonRepository extends BaseRepository
{
    public function __construct(ReturnReason $model)
    {
        parent::__construct($model);
    }
}
