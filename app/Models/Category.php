<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Casts\Attribute,
    Database\Eloquent\SoftDeletes,
    Support\Facades\Storage};
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'categories';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description',
        'content',
        'type',
        'slug',
        'status',
        'is_featured',
        'icon',
        'position',
        'products_count',
        'image',
        'parent_id',
        'creator_id',
        'editor_id',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'content' => 'string',
        'type' => 'string',
        'slug' => 'string',
        'status' => 'int',
        'is_featured' => 'int',
        'icon' => 'string',
        'position' => 'int',
        'products_count' => 'int',
        'image' => 'string',
        'parent_id' => 'int',
        'creator_id' => 'int',
        'editor_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            delete_file($category);
        });

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = slugify(string: $category->name, model: self::class);
            }
        });
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function allCategories(): array
    {
        $categories = self::with(['children' => function ($query) {
                        $query->orderBy('position');
                    }])->whereNull('parent_id')
                    ->orderBy('position')
                    ->get();

        return self::formatCategories($categories);
    }

    private static function formatCategories($categories, $prefix = ''): array
    {
        $formatted = [];

        foreach ($categories as $category) {
            $formatted[$category->id] = $prefix . ucfirst($category->name);

            if ($category->children->isNotEmpty()) {
                $formatted += self::formatCategories($category->children, $prefix . '-- ');
            }
        }

        return $formatted;
    }

    /**
     * @return array
     */
    public static function allParentCategories(): array
    {
        $categories = [];
        $data = self::whereNull('parent_id')->get();
        foreach ($data as $category) {
            $categories[$category->id] = ucfirst($category->name);
        }
        return $categories;
    }

    public function getAllDescendantIds(): array
    {
        $ids = $this->children()->pluck('id')->toArray();

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }

        return $ids;
    }
}
