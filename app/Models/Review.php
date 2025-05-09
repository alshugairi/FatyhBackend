<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\BelongsTo, SoftDeletes};

class Review extends Model
{
    use HasFactory,ModelAttributesTrait;

    protected $fillable = [
        'business_id',
        'product_id',
        'user_id',
        'rating',
        'review'
    ];

    protected $casts = [
        'business_id' => 'integer',
        'product_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'review' => 'string',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
