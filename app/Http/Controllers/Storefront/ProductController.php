<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            $this->query()->orderBy('sort_order')->orderBy('name')->get()
        );
    }

    public function show(string $slug): JsonResponse
    {
        return response()->json(
            $this->query()->where('slug', $slug)->firstOrFail()
        );
    }

    private function query(): Builder
    {
        return Product::query()
            ->where('is_active', true)
            ->whereHas('variants', fn (Builder $query) => $query->where('is_active', true))
            ->with([
                'brand:id,name,slug',
                'category:id,name,slug',
                'condition:id,name,slug',
                'variants' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order'),
                'badges:id,name,slug',
                'ingredients:id,name,slug',
                'benefits:id,name,slug',
                'skinTypes:id,name,slug',
            ]);
    }
}
