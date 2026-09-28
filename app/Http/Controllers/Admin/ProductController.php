<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private const RELATIONS = [
        'brand:id,name',
        'category:id,name',
        'condition:id,name',
        'variants',
        'images',
        'badges:id,name',
        'ingredients:id,name',
        'benefits:id,name',
        'skinTypes:id,name',
    ];

    public function index(): JsonResponse
    {
        $products = Product::query()
            ->with(self::RELATIONS)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatedData($request);

        $product = DB::transaction(function () use ($data) {
            $product = Product::create($this->productAttributes($data));
            $this->syncProductRelations($product, $data);

            return $product;
        });

        return response()->json($this->loadProduct($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($this->loadProduct($product));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $data = $this->validatedData($request, $product);

        DB::transaction(function () use ($product, $data) {
            $product->update($this->productAttributes($data));
            $this->syncProductRelations($product, $data);
        });

        return response()->json($this->loadProduct($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(status: 204);
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Product $product = null): array
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['slug'] ?? $input['name'] ?? '');

        $validator = validator($input, [
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'condition_id' => ['nullable', 'integer', Rule::exists('product_conditions', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product?->id),
            ],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'badge_ids' => ['sometimes', 'array'],
            'badge_ids.*' => ['integer', 'distinct', Rule::exists('badges', 'id')],
            'ingredient_ids' => ['sometimes', 'array'],
            'ingredient_ids.*' => ['integer', 'distinct', Rule::exists('ingredients', 'id')],
            'benefit_ids' => ['sometimes', 'array'],
            'benefit_ids.*' => ['integer', 'distinct', Rule::exists('benefits', 'id')],
            'skin_type_ids' => ['sometimes', 'array'],
            'skin_type_ids.*' => ['integer', 'distinct', Rule::exists('skin_types', 'id')],
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => ['nullable', 'integer', Rule::exists('product_variants', 'id')],
            'variants.*.sku' => ['nullable', 'string', 'max:255', 'distinct'],
            'variants.*.variant_name' => ['nullable', 'string', 'max:255'],
            'variants.*.size_value' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'variants.*.size_unit' => ['nullable', 'string', 'max:50'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'variants.*.is_price_on_request' => ['sometimes', 'boolean'],
            'variants.*.stock_quantity' => ['sometimes', 'integer', 'min:0'],
            'variants.*.track_stock' => ['sometimes', 'boolean'],
            'variants.*.is_default' => ['sometimes', 'boolean'],
            'variants.*.is_active' => ['sometimes', 'boolean'],
            'variants.*.sort_order' => ['sometimes', 'integer', 'min:0'],
            'images' => ['sometimes', 'array'],
            'images.*.id' => ['nullable', 'integer', Rule::exists('product_images', 'id')],
            'images.*.product_variant_id' => ['nullable', 'integer', Rule::exists('product_variants', 'id')],
            'images.*.file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
            'images.*.is_primary' => ['sometimes', 'boolean'],
            'images.*.sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $validator->after(function ($validator) use ($input, $product) {
            if (collect($input['variants'] ?? [])->where('is_default', true)->count() > 1) {
                $validator->errors()->add('variants', 'Only one variant can be the default.');
            }

            if (collect($input['images'] ?? [])->where('is_primary', true)->count() > 1) {
                $validator->errors()->add('images', 'Only one image can be primary.');
            }

            foreach ($input['variants'] ?? [] as $index => $variant) {
                if (! empty($variant['id']) && $product && ! $product->variants()->whereKey($variant['id'])->exists()) {
                    $validator->errors()->add("variants.$index.id", 'The variant does not belong to this product.');
                }

                if (! empty($variant['sku'])) {
                    $unique = Rule::unique('product_variants', 'sku')->ignore($variant['id'] ?? null);
                    $skuValidator = validator(['sku' => $variant['sku']], ['sku' => [$unique]]);

                    if ($skuValidator->fails()) {
                        $validator->errors()->add("variants.$index.sku", 'The SKU has already been taken.');
                    }
                }
            }

            foreach ($input['images'] ?? [] as $index => $image) {
                if (! empty($image['id']) && $product && ! $product->images()->whereKey($image['id'])->exists()) {
                    $validator->errors()->add("images.$index.id", 'The image does not belong to this product.');
                }

                if (empty($image['id']) && empty($image['file'])) {
                    $validator->errors()->add("images.$index.file", 'Please upload an image.');
                }
            }
        });

        return $validator->validate();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function productAttributes(array $data): array
    {
        return Arr::only($data, [
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
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncProductRelations(Product $product, array $data): void
    {
        $product->badges()->sync($this->orderedPivot($data['badge_ids'] ?? []));
        $product->ingredients()->sync($this->orderedPivot($data['ingredient_ids'] ?? []));
        $product->benefits()->sync($this->orderedPivot($data['benefit_ids'] ?? []));
        $product->skinTypes()->sync($data['skin_type_ids'] ?? []);

        $keptVariantIds = [];

        foreach ($data['variants'] as $index => $attributes) {
            $variantId = $attributes['id'] ?? null;
            unset($attributes['id']);
            $attributes['sort_order'] ??= $index;

            $variant = $variantId
                ? $product->variants()->whereKey($variantId)->firstOrFail()
                : new ProductVariant;

            $variant->fill($attributes);
            $variant->product()->associate($product);
            $variant->save();
            $keptVariantIds[] = $variant->id;
        }

        $product->variants()->whereNotIn('id', $keptVariantIds)->delete();

        $keptImageIds = [];

        foreach ($data['images'] ?? [] as $index => $attributes) {
            $imageId = $attributes['id'] ?? null;
            $uploadedFile = $attributes['file'] ?? null;
            unset($attributes['id']);
            unset($attributes['file']);
            $attributes['sort_order'] ??= $index;

            if (! empty($attributes['product_variant_id']) && ! in_array($attributes['product_variant_id'], $keptVariantIds, true)) {
                throw ValidationException::withMessages([
                    "images.$index.product_variant_id" => ['The selected variant does not belong to this product.'],
                ]);
            }

            $image = $imageId
                ? $product->images()->whereKey($imageId)->firstOrFail()
                : new ProductImage;

            if ($uploadedFile instanceof UploadedFile) {
                $attributes['image_path'] = $this->storeProductImage($uploadedFile);
            }

            $image->fill($attributes);
            $image->product()->associate($product);
            $image->save();
            $keptImageIds[] = $image->id;
        }

        $product->images()->whereNotIn('id', $keptImageIds)->delete();
    }

    /**
     * @param  array<int, int>  $ids
     * @return array<int, array{sort_order: int}>
     */
    private function orderedPivot(array $ids): array
    {
        return collect($ids)
            ->values()
            ->mapWithKeys(fn (int $id, int $index) => [$id => ['sort_order' => $index]])
            ->all();
    }

    private function loadProduct(Product $product): Product
    {
        return $product->fresh()->load(self::RELATIONS);
    }

    private function storeProductImage(UploadedFile $file): string
    {
        $directory = public_path('images/products');
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid().'.'.$file->extension();
        $file->move($directory, $filename);

        return '/images/products/'.$filename;
    }
}
