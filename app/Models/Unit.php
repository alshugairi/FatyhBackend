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

class Unit extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'units';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'image',
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'description' => 'string',
        'status' => 'string',
        'image' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($unit) {
            if ($unit->image) {
                if (Storage::disk('public')->exists($unit->image)) {
                    Storage::disk('public')->delete($unit->image);
                }
            }
        });
    }

    /**
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => !empty($value) ? asset('public'.Storage::url($value)) : null
        );
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $units = [];
        $data = self::get();
        foreach ($data as $unit) {
            $units[$unit->id] = ucfirst($unit->name);
        }
        return $units;
    }
}
