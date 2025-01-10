<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Support\Facades\Cache};
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasFactory, HasTranslations, ModelAttributesTrait;

    protected $table = 'menus';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'position',
        'code',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'position' => 'string',
        'code' => 'string',
        'status' => 'int'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_menus');
        });

        static::deleted(function () {
            Cache::forget('all_menus');
        });
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }
}
