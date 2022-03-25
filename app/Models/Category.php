<?php

namespace App\Models;

use App\Core\Models\CoreModel;
use App\Helpers\TranslatableJson;
use App\Traits\Author;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends CoreModel
{
    use HasFactory, SoftDeletes, Author;

    public const CATEGORY_RESOURCES = 'CATEGORY_RESOURCES';

    protected $fillable = [
        'name',
        'description',
        'author_id',
        'parent_id',
        'position',
        'is_active'
    ];

    protected $casts = [
        'name' => TranslatableJson::class,
        'description' => TranslatableJson::class,
    ];

    public function ico(): MorphOne
    {
        return $this->morphOne(Resource::class, 'resource');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    public function scopeActive($q)
    {
        return $q->whereActive('=', true);
    }

    public function getSubDescriptionAttribute(): string|null
    {
        return subText($this->description);
    }
}
