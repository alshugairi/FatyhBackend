<?php

namespace App\Repositories\Settings;

use App\{Models\FaqGroup, Repositories\BaseRepository};

class FaqGroupRepository extends BaseRepository
{
    public function __construct(FaqGroup $model)
    {
        parent::__construct($model);
    }
}
