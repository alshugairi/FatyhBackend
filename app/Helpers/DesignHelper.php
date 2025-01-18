<?php

namespace App\Helpers;

use App\{Enums\StatusEnum, Models\User};
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
            StatusEnum::INACTIVE->value => $isHtml ? "<span class='badge bg-danger'>".__('admin.inactive')."</span>" : __('admin.inactive'),
            StatusEnum::ACTIVE->value =>  $isHtml ? "<span class='badge bg-primary'>".__('admin.active')."</span>" : __('admin.active'),
            StatusEnum::DELETED->value => $isHtml ? "<span class='badge bg-danger'>".__('admin.deleted')."</span>" : __('admin.deleted'),
            default => "",
        };
    }

    public static function renderStatus(int $status, $isHtml = true): string
    {
        return match ($status) {
            StatusEnum::INACTIVE->value => $isHtml ? "<span class='badge bg-danger'>".__('admin.inactive')."</span>" : __('admin.inactive'),
            StatusEnum::ACTIVE->value =>  $isHtml ? "<span class='badge bg-primary'>".__('admin.active')."</span>" : __('admin.active'),
            default => "",
        };
    }
}


