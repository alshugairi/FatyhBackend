<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\BelongsTo, SoftDeletes};

class Question extends Model
{
    use HasFactory,ModelAttributesTrait;

    protected $fillable = [
        'business_id',
        'product_id',
        'user_id',
        'question',
        'reply'
    ];

    protected $casts = [
        'business_id' => 'integer',
        'product_id' => 'integer',
        'user_id' => 'integer',
        'question' => 'string',
        'reply' => 'string',
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
