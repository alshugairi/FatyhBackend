<?php

namespace App\Repositories\Settings;

use App\{Models\Language, Repositories\BaseRepository};

class LanguageRepository extends BaseRepository
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
