<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Casts\Attribute,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'cities';

    public $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'country_id',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'name' => 'string',
        'country_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $cities = [];
        $data = self::get();
        foreach ($data as $city) {
            $cities[$city->id] = ucfirst($city->name);
        }
        return $cities;
    }
}
