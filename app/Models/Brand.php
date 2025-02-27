<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes,
    Support\Facades\Storage};
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'brands';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'is_featured',
        'image',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'status' => 'int',
        'is_featured' => 'int',
        'image' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($brand) {
            delete_file($brand->image);
        });
    }

    /**
     * @return array
     */
    public static function allBrands(): array
    {
        $brands = [];
        $data = self::get();
        foreach ($data as $brand) {
            $brands[$brand->id] = ucfirst($brand->name);
        }
        return $brands;
    }
}
