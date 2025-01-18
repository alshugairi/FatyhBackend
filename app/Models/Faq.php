<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory, HasTranslations, ModelAttributesTrait;

    protected $table = 'faqs';

    public $translatable = [
        'question',
        'answer'
    ];

    protected $fillable = [
        'faq_group_id',
        'question',
        'answer',
        'order',
        'is_active',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'faq_group_id' => 'integer',
        'question' => 'array',
        'answer' => 'array',
        'order' => 'integer',
        'is_active' => 'boolean',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function group()
    {
        return $this->belongsTo(FaqGroup::class, 'faq_group_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
