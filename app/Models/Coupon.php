<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\Database\{Eloquent\Casts\Attribute, Eloquent\Factories\HasFactory, Eloquent\Model, Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'coupons';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'limit_per_user',
        'max_usage',
        'usage_count',
        'start_date',
        'end_date',
        'description',
        'image',
        'creator_id',
        'editor_id',
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'type' => 'string',
        'value' => 'float',
        'limit_per_user' => 'int',
        'max_usage' => 'int',
        'usage_count' => 'int',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'description' => 'string',
        'image' => 'string',
        'creator_id' => 'int',
        'editor_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at',
        'formatted_start_date',
        'formatted_end_date',
    ];

    protected $dates = ['start_date','end_date'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($brand) {
            delete_file($brand->image);
        });
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    public function incrementUsage(): void
    {
        $this->usage_count++;
        $this->save();
    }
}
