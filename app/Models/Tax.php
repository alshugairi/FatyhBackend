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

class Tax extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'taxes';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'rate',
        'description',
        'status',
        'image',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'image' => 'string',
        'creator_id' => 'integer',
        'editor_id' => 'integer'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tax) {
            delete_file($tax->image);
        });
    }

    /**
     * @return array
     */
    public static function allTaxes(): array
    {
        $taxes = [];
        $data = self::get();
        foreach ($data as $tax) {
            $taxes[$tax->id] = ucfirst($tax->name);
        }
        return $taxes;
    }
}
