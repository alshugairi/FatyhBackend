<?php

namespace App\Helpers;

use App\{Models\User,};
use Illuminate\Support\Facades\Cache;
use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DesignHelper
{
    public static function isActive(array $routePatterns): string
    {
        $status = false;
        foreach ($routePatterns as $routePattern) {
            if ($status) break;
            $status = str_contains(request()?->fullUrl(), $routePattern)  ? true : false;
        }

        return $status ? ' active' : '';
    }

    public static function isShow(array $routePatterns): string
    {
        $status = false;
        foreach ($routePatterns as $routePattern) {
            if ($status) break;
            $status = str_contains(request()?->fullUrl(), $routePattern)  ? true : false;
        }

        return $status ? ' menu-open ' : '';
    }

    public static function renderImage($image): string
    {
        return '<img src="'.get_full_image_url($image).'" alt="image" class="img-thumbnail" style="max-width: 100px;">';
    }

    public static function parseOrderStatus(int $status, $isHtml = true): string
    {
        return match ($status) {
            StatusEnum::InActive->value => $isHtml ? "<span class='badge badge-danger'>".__('share.inactive')."</span>" : __('share.inactive'),
            StatusEnum::Active->value =>  $isHtml ? "<span class='badge badge-primary'>".__('share.active')."</span>" : __('share.active'),
            StatusEnum::Deleted->value => $isHtml ? "<span class='badge badge-danger'>".__('share.deleted')."</span>" : __('share.deleted'),
            default => "",
        };
    }
}


