<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class AttributeModel extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'attributes';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'type',
        'status',
        'is_required',
        'is_visible',
        'position'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'status' => 'int',
        'is_required' => 'bool',
        'is_visible' => 'bool',
        'position' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }
}
