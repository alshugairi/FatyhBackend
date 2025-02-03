<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Casts\Attribute,
    Support\Facades\Cache,
    Support\Facades\Storage};
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations, ModelAttributesTrait;

    protected $table = 'posts';

    public $translatable = [
        'name',
        'description',
        'content',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected $fillable = [
        'name',
        'description',
        'content',
        'type',
        'slug',
        'status',
        'show_in_footer',
        'show_in_top_bar',
        'position',
        'link',
        'icon',
        'image',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'creator_id',
        'editor_id',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'content' => 'string',
        'type' => 'string',
        'slug' => 'string',
        'status' => 'bool',
        'show_in_footer' => 'bool',
        'show_in_top_bar' => 'bool',
        'position' => 'int',
        'link' => 'string',
        'icon' => 'string',
        'image' => 'string',
        'seo_title' => 'string',
        'seo_description' => 'string',
        'seo_keywords' => 'string',
        'creator_id' => 'int',
        'editor_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug) && !empty($post->name)) {
                $post->slug = slugify(string: $post->name, model: self::class);
            }
        });

        static::saved(function () {
            Cache::forget('site_pages');
        });

        static::deleting(function ($post) {
            Cache::forget('site_pages');
            delete_file($post->image);
        });
    }

}
