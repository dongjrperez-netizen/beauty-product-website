<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Benefit extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_benefits')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
