<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Support\Facades\Cache};

class Settings extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'settings';
    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'key' => 'string',
        'value' => 'string',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_settings');
        });

        static::deleted(function () {
            Cache::forget('all_settings');
        });
    }
}
