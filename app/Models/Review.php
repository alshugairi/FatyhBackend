<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};

class Review extends Model
{
    use HasFactory,ModelAttributesTrait;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'review' => 'string',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
