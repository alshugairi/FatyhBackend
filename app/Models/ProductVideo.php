<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model};

class ProductVideo extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'product_videos';

    protected $fillable = [
        'product_id',
        'provider',
        'video_path',
        'is_main',
        'position'
    ];

    protected $casts = [
        'product_id' => 'int',
        'provider' => 'string',
        'video_path' => 'string',
        'is_main' => 'bool',
        'position' => 'int'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}
