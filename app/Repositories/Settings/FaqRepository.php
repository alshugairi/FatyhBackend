<?php

namespace App\Repositories\Settings;

use App\{Models\Faq, Repositories\BaseRepository};

class FaqRepository extends BaseRepository
{
    public function __construct(Faq $model)
    {
        parent::__construct($model);
    }
}
