<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletes};
use Spatie\Translatable\HasTranslations;

class ReturnReason extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'return_reasons';

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'creator_id' => 'integer',
        'editor_id' => 'integer'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    /**
     * @return array
     */
    public static function allReasons(): array
    {
        $reasons = [];
        $data = self::get();
        foreach ($data as $reason) {
            $reasons[$reason->id] = ucfirst($reason->name);
        }
        return $reasons;
    }
}
