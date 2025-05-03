<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Relations\HasMany,
    Database\Eloquent\SoftDeletes,
    Support\Facades\Storage};

class Business extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $table = 'businesses';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'is_active',
        'logo',
        'cover',
        'followers_count',
        'rating',
        'reviews_count',
        'success_orders_count',
        'cancelled_orders_count',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'website' => 'string',
        'is_active' => 'integer',
        'image' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating');
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }
}
