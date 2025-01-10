<?php

namespace App\Repositories\Settings;

use App\{Models\Settings, Repositories\BaseRepository};

class SettingsRepository extends BaseRepository
{
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }
}
