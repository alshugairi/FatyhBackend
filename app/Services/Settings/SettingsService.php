<?php

namespace App\Services\Settings;

use App\Repositories\Settings\SettingsRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;

class SettingsService extends BaseService
{
    public function __construct(SettingsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function saveSettings(array $data, string $prefix): void
    {
        foreach ($data as $key => $value) {
            if (in_array($key, ['theme_logo','theme_favicon','theme_light_logo']) && !empty($value)) {
                $data = upload_file($data, $key, 'theme');
                $value = $data[$key];
            }
            $this->repository->getModel()->updateOrCreate(['key' => $key],['value' => $value]);
            Cache::forget('setting_'.$key);

            if ($key == 'site_currency_id') {
                Cache::forget('default_currency');
            }
        }
    }
}
