<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminCatalogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_catalog_routes_require_authentication(): void
    {
        $this->getJson('/api/admin/dashboard')->assertUnauthorized();
        $this->getJson('/api/admin/products')->assertUnauthorized();
        $this->postJson('/api/admin/catalog/brands', [
            'name' => 'Test Brand',
        ])->assertUnauthorized();
    }

    public function test_authenticated_user_can_manage_catalog_entities(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $brand = $this->postJson('/api/admin/catalog/brands', [
            'name' => 'Maria Beauty',
            'is_active' => true,
        ])->assertCreated()->json();

        $this->assertSame('maria-beauty', $brand['slug']);
        $this->assertDatabaseHas('brands', [
            'name' => 'Maria Beauty',
            'slug' => 'maria-beauty',
        ]);

        $this->putJson("/api/admin/catalog/brands/{$brand['id']}", [
            'name' => 'Maria Beauty Co.',
            'slug' => 'maria-beauty-company',
            'is_active' => false,
        ])->assertOk()->assertJsonPath('is_active', false);
    }

    public function test_authenticated_user_can_create_a_normalized_product(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $brandId = $this->postJson('/api/admin/catalog/brands', [
            'name' => 'Maria Beauty',
        ])->assertCreated()->json('id');

        $categoryId = $this->postJson('/api/admin/catalog/categories', [
            'name' => 'Facial Care',
        ])->assertCreated()->json('id');

        $conditionId = $this->postJson('/api/admin/catalog/conditions', [
            'name' => 'New',
        ])->assertCreated()->json('id');

        $badgeId = $this->postJson('/api/admin/catalog/badges', [
            'name' => 'Best Seller',
        ])->assertCreated()->json('id');

        $ingredientId = $this->postJson('/api/admin/catalog/ingredients', [
            'name' => 'Niacinamide',
        ])->assertCreated()->json('id');

        $benefitId = $this->postJson('/api/admin/catalog/benefits', [
            'name' => 'Brightening',
        ])->assertCreated()->json('id');

        $skinTypeId = $this->postJson('/api/admin/catalog/skin-types', [
            'name' => 'Sensitive',
        ])->assertCreated()->json('id');

        $response = $this->post('/api/admin/products', [
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'condition_id' => $conditionId,
            'name' => 'Maria Glow Serum',
            'short_description' => 'A lightweight brightening serum.',
            'description' => 'A daily serum formulated for a brighter complexion.',
            'is_featured' => true,
            'is_active' => true,
            'badge_ids' => [$badgeId],
            'ingredient_ids' => [$ingredientId],
            'benefit_ids' => [$benefitId],
            'skin_type_ids' => [$skinTypeId],
            'variants' => [[
                'sku' => 'MGS-30ML',
                'variant_name' => '30 ml bottle',
                'size_value' => 30,
                'size_unit' => 'ml',
                'price' => 799.50,
                'stock_quantity' => 12,
                'track_stock' => true,
                'is_default' => true,
                'is_active' => true,
            ]],
            'images' => [[
                'file' => UploadedFile::fake()->image('maria-glow-serum.jpg'),
                'alt_text' => 'Maria Glow Serum bottle',
                'is_primary' => true,
            ]],
        ], ['Accept' => 'application/json']);

        $response
            ->assertCreated()
            ->assertJsonPath('slug', 'maria-glow-serum')
            ->assertJsonPath('variants.0.price', '799.50')
            ->assertJsonCount(1, 'badges')
            ->assertJsonCount(1, 'ingredients')
            ->assertJsonCount(1, 'benefits')
            ->assertJsonCount(1, 'skin_types');

        $productId = $response->json('id');
        $imagePath = $response->json('images.0.image_path');

        $this->assertStringStartsWith('/images/products/', $imagePath);
        $this->assertFileExists(public_path(ltrim($imagePath, '/')));

        $this->assertDatabaseHas('products', [
            'id' => $productId,
            'category_id' => $categoryId,
            'brand_id' => $brandId,
        ]);
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $productId,
            'sku' => 'MGS-30ML',
        ]);
        $this->assertDatabaseHas('product_images', [
            'product_id' => $productId,
            'image_path' => $imagePath,
        ]);
        $this->assertDatabaseHas('product_badges', [
            'product_id' => $productId,
            'badge_id' => $badgeId,
        ]);
        $this->assertDatabaseHas('product_ingredients', [
            'product_id' => $productId,
            'ingredient_id' => $ingredientId,
        ]);

        File::delete(public_path(ltrim($imagePath, '/')));
    }

    public function test_storefront_only_returns_active_products_with_active_variants(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $categoryId = $this->postJson('/api/admin/catalog/categories', [
            'name' => 'Soap',
        ])->assertCreated()->json('id');

        $active = $this->postJson('/api/admin/products', [
            'name' => 'Visible Soap',
            'category_id' => $categoryId,
            'is_active' => true,
            'variants' => [[
                'variant_name' => 'Single bar',
                'price' => 99,
                'is_default' => true,
                'is_active' => true,
            ]],
        ])->assertCreated()->json();

        $this->postJson('/api/admin/products', [
            'name' => 'Hidden Soap',
            'category_id' => $categoryId,
            'is_active' => false,
            'variants' => [[
                'price' => 99,
                'is_default' => true,
                'is_active' => true,
            ]],
        ])->assertCreated();

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.name', 'Visible Soap');

        $this->getJson("/api/products/{$active['slug']}")
            ->assertOk()
            ->assertJsonPath('variants.0.variant_name', 'Single bar');
    }
}
