<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'currencies';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'symbol' => 'string',
        'exchange_rate' => 'float',
        'status' => 'boolean',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public static function allCurrencies(): array
    {
        $arr = [];
        $data = self::get();
        foreach ($data as $model) {
            $arr[$model->id] = ucfirst($model->name);
        }
        return $arr;
    }
}
