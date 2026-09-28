<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand_id',
        'category_id',
        'condition_id',
        'name',
        'slug',
        'short_description',
        'description',
        'is_featured',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(ProductCondition::class, 'condition_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'product_badges')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')
            ->withPivot(['notes', 'sort_order'])
            ->withTimestamps();
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class, 'product_benefits')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function skinTypes(): BelongsToMany
    {
        return $this->belongsToMany(SkinType::class, 'product_skin_types')
            ->withTimestamps();
    }
}
