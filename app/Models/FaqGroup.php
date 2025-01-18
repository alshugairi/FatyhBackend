<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\BelongsTo, Relations\HasMany, SoftDeletes};
use Spatie\Translatable\HasTranslations;

class FaqGroup extends Model
{
    use HasFactory,HasTranslations, ModelAttributesTrait;

    protected $table = 'faq_groups';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'name' => 'array',
        'slug' => 'string',
        'description' => 'array',
        'order' => 'integer',
        'is_active' => 'boolean',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public static function toSelect(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        return static::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
