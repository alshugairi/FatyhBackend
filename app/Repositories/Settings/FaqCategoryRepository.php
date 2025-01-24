<?php

namespace App\Repositories\Settings;

use App\{Models\FaqCategory, Repositories\BaseRepository};

class FaqCategoryRepository extends BaseRepository
{
    public function __construct(FaqCategory $model)
    {
        parent::__construct($model);
    }
}
