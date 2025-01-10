<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class AttributeOption extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'attribute_options';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'attribute_id',
        'value',
        'position'
    ];

    protected $casts = [
        'name' => 'string',
        'attribute_id' => 'integer',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function attribute()
    {
        return $this->belongsTo(AttributeModel::class);
    }
}
