<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Benefit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\ProductCondition;
use App\Models\SkinType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CatalogEntityController extends Controller
{
    /**
     * @var array<string, array{model: class-string<Model>, table: string, type: string}>
     */
    private const RESOURCES = [
        'brands' => ['model' => Brand::class, 'table' => 'brands', 'type' => 'brand'],
        'categories' => ['model' => Category::class, 'table' => 'categories', 'type' => 'category'],
        'conditions' => ['model' => ProductCondition::class, 'table' => 'product_conditions', 'type' => 'simple'],
        'badges' => ['model' => Badge::class, 'table' => 'badges', 'type' => 'simple'],
        'ingredients' => ['model' => Ingredient::class, 'table' => 'ingredients', 'type' => 'simple'],
        'benefits' => ['model' => Benefit::class, 'table' => 'benefits', 'type' => 'simple'],
        'skin-types' => ['model' => SkinType::class, 'table' => 'skin_types', 'type' => 'simple'],
    ];

    public function index(string $resource): JsonResponse
    {
        $config = $this->config($resource);
        $query = $config['model']::query()->withCount('products');

        if ($resource === 'categories') {
            $query->with('parent:id,name')->orderBy('sort_order');
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request, string $resource): JsonResponse
    {
        $config = $this->config($resource);
        $data = $this->validatedData($request, $config);
        $model = $config['model']::create($data);

        return response()->json($model->fresh(), 201);
    }

    public function update(Request $request, string $resource, int $id): JsonResponse
    {
        $config = $this->config($resource);
        $model = $config['model']::query()->findOrFail($id);
        $data = $this->validatedData($request, $config, $model);
        $model->update($data);

        return response()->json($model->fresh());
    }

    public function destroy(string $resource, int $id): JsonResponse
    {
        $config = $this->config($resource);
        $model = $config['model']::query()->findOrFail($id);

        if ($resource === 'categories' && $model->products()->exists()) {
            throw ValidationException::withMessages([
                'category' => ['This category cannot be deleted while products are assigned to it.'],
            ]);
        }

        $model->delete();

        return response()->json(status: 204);
    }

    /**
     * @return array{model: class-string<Model>, table: string, type: string}
     */
    private function config(string $resource): array
    {
        abort_unless(array_key_exists($resource, self::RESOURCES), 404);

        return self::RESOURCES[$resource];
    }

    /**
     * @param  array{model: class-string<Model>, table: string, type: string}  $config
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, array $config, ?Model $model = null): array
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['slug'] ?? $input['name'] ?? '');

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($config['table'], 'name')->ignore($model?->getKey()),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique($config['table'], 'slug')->ignore($model?->getKey()),
            ],
        ];

        if ($config['type'] === 'brand') {
            $rules['is_active'] = ['sometimes', 'boolean'];
        }

        if ($config['type'] === 'category') {
            $rules['parent_id'] = [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
                Rule::notIn(array_filter([$model?->getKey()])),
            ];
            $rules['description'] = ['nullable', 'string'];
            $rules['sort_order'] = ['sometimes', 'integer', 'min:0'];
            $rules['is_active'] = ['sometimes', 'boolean'];
        }

        return validator($input, $rules)->validate();
    }
}
