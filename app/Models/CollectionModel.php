<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Relations\HasMany};
use Spatie\Translatable\HasTranslations;

class CollectionModel extends Model
{
    use HasFactory, HasTranslations, ModelAttributesTrait;

    protected $table = 'collections';

    public $translatable = [
        'name',
        'description',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'image',
        'creator_id',
        'editor_id',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'is_active' => 'bool',
        'image' => 'string',
        'creator_id' => 'int',
        'editor_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($collection) {
            delete_file($collection->image);
        });
    }

    public function collectionProducts(): HasMany
    {
        return $this->hasMany(CollectionProduct::class, 'collection_id');
    }
}
