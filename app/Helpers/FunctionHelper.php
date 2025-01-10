<?php

use App\{Models\User,
    Models\Settings,
    Models\Currency,
    Models\Category,
    Models\Menu,
    Models\Brand,
    Enums\StatusEnum,
    Models\Post,Enums\PostType};
use Illuminate\Support\{Facades\Cache, Arr, Facades\Storage};
use Carbon\Carbon;

if (!function_exists(function: 'render_table_image')) {
    function render_table_image(string $path): string
    {
        return !empty($path) ? '<img src="'.$path.'" class="img-thumbnail rounded-2" style="max-height: 60px; width:60px">' : '';
    }
}

if (!function_exists('get_languages')) {
    function get_languages()
    {
        return Cache::remember('appLanguages', 3600, function () {
            return \App\Models\Language::all();
        });
    }
}

if (!function_exists('get_categories')) {
    function get_categories($except = []): mixed
    {
        $cachedCategories = Cache::rememberForever("categories", function () {
            return Category::with(['children' => function ($query) {
                    $query->where('status', StatusEnum::Active->value)->orderBy('position');
                }])
                ->whereNull('parent_id')
                ->where('status', StatusEnum::Active->value)
                ->orderBy('position')
                ->get();
        });

        return $cachedCategories->filter(function ($category) use ($except) {
            return !in_array($category->id, $except);
        });
    }
}

if (!function_exists('get_brands')) {
    function get_brands($except = []): mixed
    {
        return Cache::rememberForever("all_brands", function () {
            return Brand::where('status', StatusEnum::Active->value)->get();
        });
    }
}

if (!function_exists('get_all_settings')) {
    function get_all_settings(): array
    {
        return Cache::rememberForever('all_settings', function () {
            return Settings::pluck('value', 'key')->toArray();
        });
    }
}

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null): mixed
    {
        $settings = get_all_settings();

        if (isset($settings[$key])) {
            return is_image($settings[$key]) ? get_full_image_url($settings[$key]) : $settings[$key];
        }

        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = Settings::where('key', $key)->first();

            if ($setting) {
                $value = $setting->value;
                return is_image($value) ? get_full_image_url($value) : $value;
            }

            return $default;
        });
    }
}

if (!function_exists('update_setting')) {
    function update_setting(string $key, $value): void
    {
        Settings::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget('all_settings');
        get_all_settings();
    }
}

if (!function_exists('default_currency')) {
    function default_currency()
    {
        return Cache::rememberForever('default_currency', function () {
            $defaultCurrencyId = get_setting('site_currency_id');

            if ($defaultCurrencyId) {
                return Currency::find($defaultCurrencyId);
            }

            return null;
        });
    }
}

if (!function_exists('is_image')) {
    function is_image(?string $value): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

        $extension = pathinfo($value, PATHINFO_EXTENSION);

        return in_array(strtolower($extension), $imageExtensions);
    }
}

if (!function_exists('get_timezones')) {
    function get_timezones(): array
    {
        $timezones = [];
        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $timezones[$timezone] = $timezone;
        }
        return $timezones;
    }
}

if (!function_exists('upload_file')) {
    function upload_file(array $data, string $fieldName, string $folder, string $oldFile = null, string $disk = 'public'): array
    {
        if (!empty($data[$fieldName])) {
            try {
                $data[$fieldName] = $data[$fieldName]->store($folder, $disk);

                if ($oldFile && Storage::disk($disk)->exists($oldFile)) {
                    Storage::disk($disk)->delete($oldFile);
                }
            } catch (Exception $e) {
                $data = Arr::except($data, [$fieldName]);
                throw new \RuntimeException('Failed to upload or delete file: ' . $e->getMessage());
            }
        } else {
            $data = Arr::except($data, [$fieldName]);
        }

        return $data;
    }
}

if (!function_exists('delete_file')) {
    function delete_file(string $fieldName, string $disk = 'public'): void
    {
        if ($fieldName) {
            if (Storage::disk($disk)->exists($fieldName)) {
                Storage::disk($disk)->delete($fieldName);
            }
        }
    }
}

if (!function_exists('get_full_image_url')) {
    function get_full_image_url(?string $relativePath): string
    {
        return $relativePath ? asset(Storage::url($relativePath)) : asset('assets/admin/images/no-image.png');
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            $format = get_setting('site_date_format', 'Y-m-d');
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('format_time')) {
    function format_time(?string $time): ?string
    {
        if (!$time) {
            return null;
        }

        try {
            $format = get_setting('site_time_format', 'H:i');
            return Carbon::parse($time)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime(?string $datetime): ?string
    {
        if (!$datetime) {
            return null;
        }

        try {
            $dateFormat = get_setting('site_date_format', 'Y-m-d');
            $timeFormat = get_setting('site_time_format', 'H:i');

            $format = "{$dateFormat} {$timeFormat}";
            return Carbon::parse($datetime)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount, $html = false): string
    {
        $currency = default_currency();
        $currencyPosition = get_setting('site_currency_position');
        $currencyPrecision = get_setting('site_precision', 2);

        if ($currency) {
            $formattedAmount = number_format($amount, $currencyPrecision);

            if ($html) {
                if ($currencyPosition === 'left') {
                    return "<span class='currency'>{$currency->symbol}</span> <span class='price_number mx-1'>{$formattedAmount}</span>";
                } elseif ($currencyPosition === 'right') {
                    return "<span class='price_number mx-1'>{$formattedAmount}</span> <span class='currency'>{$currency->symbol}</span>";
                }
            } else {
                if ($currencyPosition === 'left') {
                    return $currency->symbol . ' ' . $formattedAmount;
                } elseif ($currencyPosition === 'right') {
                    return $formattedAmount . ' ' . $currency->symbol;
                }
            }
        }

        return number_format($amount, $currencyPrecision);
    }
}


if (!function_exists('localized_url')) {
    function localized_url($locale, $routeName, $parameters = [])
    {
        if ($locale === config('app.locale')) {
            return route($routeName, $parameters);
        }

        return route($routeName, array_merge(['locale' => $locale], $parameters));
    }
}

if (!function_exists('slugify')) {
    function slugify($string, $model = null)
    {
        $slug = preg_replace('~[^\pL\d]+~u', '-', $string);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '-');
        $slug = strtolower($slug);

        $count = $model::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        return $slug;
    }
}

if (!function_exists('get_site_pages')) {
    function get_site_pages()
    {
        return Cache::rememberForever('site_pages', function () {
            return Post::where('type', PostType::PAGE->value)
            ->where('status', 1)
            ->orderBy('position')
            ->get();
        });
    }
}

if (!function_exists('get_menu')) {
    function get_menu($position = null, $code = null)
    {
        $allMenus = Cache::rememberForever('all_menus', function () {
            return Menu::where('status', StatusEnum::Active->value)
                ->with('items.children')
                ->get();
        });

        return $allMenus->when($position, function ($query) use ($position) {
                return $query->where('position', $position);
            })
            ->when($code, function ($query) use ($code) {
                return $query->where('code', $code);
            })
            ->first();
    }
}

if (!function_exists('render_primary_menu')) {
    function render_primary_menu()
    {
        $primaryMenu = get_menu(position: 'primary');

        $html = '<nav class="navbar navbar-expand-lg ms-4">';
        $html .= '<div class="main-nav">';
        $html .= '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
        $html .= '<span class="navbar-toggler-icon"></span>';
        $html .= '</button>';
        $html .= '<div class="collapse navbar-collapse" id="navbarNav">';
        $html .= '<ul class="navbar-nav ms-auto">';

        foreach ($primaryMenu->items as $menuItem) {
            $html .= render_menu_item($menuItem);
        }

        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</nav>';

        return $html;
    }
}

if (!function_exists('render_menu_item')) {
    function render_menu_item($menuItem)
    {
        $hasChildren = $menuItem->children->isNotEmpty();
        $html = '';

        $menuItemName = !empty($menuItem->translation_key) ? __('frontend.'.$menuItem->translation_key) : $menuItem->name;
        if ($hasChildren) {
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a class="nav-link dropdown-toggle main-nav-item" href="#" id="navbarDropdown' . $menuItem->id . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
            $html .= $menuItemName . '';
            $html .= '</a>';
            $html .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown' . $menuItem->id . '">';

            foreach ($menuItem->children as $child) {
                $html .= '<li><a class="dropdown-item main-nav-item" href="' . $child->url . '">' . $child->name . '</a></li>';
            }

            $html .= '</ul>';
            $html .= '</li>';
        } else {
            $html .= '<li class="nav-item">';
            $html .= '<a class="nav-link main-nav-item" href="' . $menuItem->url . '">' . $menuItemName . '</a>';
            $html .= '</li>';
        }

        return $html;
    }
}

if (!function_exists('render_stars')) {
    function render_stars($rating, $maxStars = 5)
    {
        $fullStars = floor($rating);
        $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
        $emptyStars = $maxStars - $fullStars - $halfStar;

        $starsHtml = '';

        for ($i = 0; $i < $fullStars; $i++) {
            $starsHtml .= '<i class="fas fa-star"></i>';
        }

        if ($halfStar) {
            $starsHtml .= '<i class="fas fa-star-half-alt"></i>';
        }

        for ($i = 0; $i < $emptyStars; $i++) {
            $starsHtml .= '<i class="far fa-star"></i>';
        }

        return $starsHtml;
    }
}

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }
        return rtrim(mb_substr($value, 0, $limit)) . $end;
    }
}

if (!function_exists('get_default_image')) {
    function get_default_image(): string
    {
        return asset('assets/admin/images/no-image.png');
    }
}



