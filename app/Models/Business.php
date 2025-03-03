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
        'status',
        'logo',
        'followers_count',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'website' => 'string',
        'status' => 'integer',
        'logo' => 'string'
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
}
