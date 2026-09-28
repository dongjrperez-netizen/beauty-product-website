<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Benefit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductCondition;
use App\Models\SkinType;
use Illuminate\Http\JsonResponse;

class CatalogDashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'counts' => [
                'products' => Product::count(),
                'brands' => Brand::count(),
                'categories' => Category::count(),
                'conditions' => ProductCondition::count(),
                'badges' => Badge::count(),
                'ingredients' => Ingredient::count(),
                'benefits' => Benefit::count(),
                'skin_types' => SkinType::count(),
            ],
            'options' => [
                'brands' => Brand::orderBy('name')->get(),
                'categories' => Category::with('parent:id,name')->orderBy('sort_order')->orderBy('name')->get(),
                'conditions' => ProductCondition::orderBy('name')->get(),
                'badges' => Badge::orderBy('name')->get(),
                'ingredients' => Ingredient::orderBy('name')->get(),
                'benefits' => Benefit::orderBy('name')->get(),
                'skin_types' => SkinType::orderBy('name')->get(),
            ],
        ]);
    }
}
