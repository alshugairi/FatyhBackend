<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Relations\HasMany,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'countries';

    public $translatable = [
        'name',
        'nationality',
    ];

    protected $fillable = [
        'name',
        'timezone',
        'nationality',
        'iso2',
        'iso3',
        'dial_code',
        'priority',
        'flag_emoji',
        'flag_emoji_unicode',
        'currency_id'
    ];

    protected $casts = [
        'name' => 'string',
        'timezone' => 'string',
        'nationality' => 'string',
        'iso2' => 'string',
        'iso3' => 'string',
        'dial_code' => 'string',
        'priority' => 'int',
        'flag_emoji' => 'string',
        'flag_emoji_unicode' => 'string',
        'currency_id' => 'int'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $countries = [];
        $data = self::get();
        foreach ($data as $country) {
            $countries[$country->id] = ucfirst($country->name);
        }
        return $countries;
    }
}
