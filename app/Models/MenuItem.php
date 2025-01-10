<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model};
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasFactory,HasTranslations, ModelAttributesTrait;

    protected $table = 'menu_items';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'menu_id',
        'parent_id',
        'name',
        'translation_key',
        'type',
        'related_id',
        'url',
        'order'
    ];

    protected $casts = [
        'menu_id' => 'int',
        'parent_id' => 'int',
        'translation_key' => 'string',
        'type' => 'string',
        'related_id' => 'int',
        'url' => 'string',
        'order' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function relatedEntity(): Model|null
    {
        switch ($this->type) {
            case 'static':
                return null;
            case 'category':
                return Category::find($this->related_id);
            case 'brand':
                return Brand::find($this->related_id);
            default:
                return null;
        }
    }
}
