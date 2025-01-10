<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model};

class ProductImage extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'is_main',
        'position'
    ];

    protected $casts = [
        'product_id' => 'int',
        'image_path' => 'string',
        'alt_text' => 'string',
        'is_main' => 'bool',
        'position' => 'int'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productImage) {
            if ($productImage->image_path) {
                delete_file($productImage->image_path);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}
