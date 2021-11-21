<?php

namespace Tests\Feature\API;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private int $nonExistentId = 5430;

    /**
     * Test status code on read endpoint
     * Should return 200 - 'Ok'
     */
    public function test_get_all_products()
    {
        Product::factory(10)->create();

        $countProducts = Product::where('active', 1)->count();

        $this->json('GET', 'api/products')
            ->assertJsonCount($countProducts, 'data')
            ->assertStatus(200);
    }

    /**
     * Test status code on read endpoint with pagination
     * Should return 200 - 'Ok'
     */
    public function test_get_all_products_with_pagination()
    {
        Product::factory(500)->create();
        $limit = rand(1, 260);
        $page = 500 / $limit;

        $this->json('GET', 'api/products?page=' . (int)$page . '&limit=' . $limit)
            ->assertJsonCount($limit, 'data')
            ->assertStatus(200);
    }

    /**
     * Test status code on read(one) endpoint
     * Should return 200 - 'Ok'
     */
    public function test_get_one_product()
    {
        $product = Product::factory()->create();

        $this->json('GET', 'api/products/' . $product->id)
            ->assertJson(fn(AssertableJson $json) => $json->has('data'))
            ->assertStatus(200);
    }

    /**
     * Test setting disable status to a product
     * Should return 200 - 'Ok' on creating
     * Should return 200 - 'Ok' on getting
     */
    public function test_get_inactive_products()
    {
        Product::factory(10)->create();
        $randomProduct = Product::inRandomOrder()->first();

        $this->json('PUT', 'api/products/' . $randomProduct->id . '/archive', [
            'active' => 0
        ])->assertStatus(200);

        $this->json('GET', 'api/products?active=0')
            ->assertJsonCount(1, 'data')
            ->assertStatus(200);
    }

    /**
     * Test setting disable status to a product
     * Should return 200 - 'Ok' on creating
     * Should return 200 - 'Ok' on getting
     */
    public function test_get_active_products()
    {
        Product::factory(10)->create(['active' => 0]);
        $randomProduct = Product::inRandomOrder()->first();

        $this->json('PUT', 'api/products/' . $randomProduct->id . '/archive', [
            'active' => 1
        ])->assertStatus(200);

        $this->json('GET', 'api/products?active=1')
            ->assertJsonCount(1, 'data')
            ->assertStatus(200);
    }

    /**
     * Test status code on create endpoint
     * Should return 201 - 'Created'
     */
    public function test_create_product()
    {
        $this->post('api/products/', [
            'name' => 'Lorem',
            'code' => 'A-' . uniqid(),
            'barcode' => uniqid(),
        ])->assertStatus(201);
    }

    /**
     * Test status code on update endpoint
     * Should return 200 - 'Ok'
     */
    public function test_update_product()
    {
        $product = Product::factory()->create();

        $this->put('api/products/' . $product->id, [
            'name' => 'Lorem',
            'code' => 'A-' . uniqid(),
            'barcode' => uniqid(),
        ])->assertStatus(200);
    }

    /**
     * Test status code on delete endpoint
     * Should return 204 - 'No Content'
     */
    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $this->delete('api/products/' . $product->id)->assertStatus(204);
    }

    /**
     * Test auto generates slug
     * Should return 201 - 'Created'
     */
    public function test_generate_product_slug()
    {
        $this->json('POST', 'api/products', [
            'name' => 'lorem Ipsum ...||',
            'code' => 'A-' . uniqid(),
            'barcode' => uniqid(),
        ])
            ->assertJson(fn(AssertableJson $json) => $json->has('data', fn($json) => $json->where('slug', 'lorem-ipsum')->etc()
            ))
            ->assertStatus(201);
    }

    /**
     * Test status code when product not found
     * Should return 404 - 'Not Found'
     */
    public function test_throw_when_product_not_found()
    {
        $this->json('GET', 'api/products/' . $this->nonExistentId)->assertStatus(404);
    }

    /**
     * Test status code when validation fail
     * Should return 422 - 'Unprocessable Entity'
     */
    public function test_throw_when_validation_fail_on_create_product()
    {
        $this->json('POST', 'api/products')->assertStatus(422);
    }

    /**
     * Test status code when product not found on updating
     * Should return 404 - 'Not Found'
     */
    public function test_throw_when_product_not_found_on_update()
    {
        $this->json('PUT', 'api/products/' . $this->nonExistentId)->assertStatus(404);
    }

    /**
     * Test status code when validation fail
     * Should return 422 - 'Unprocessable Entity'
     */
    public function test_throw_when_validation_fail_on_update_product()
    {
        $product = Product::factory()->create();

        $this->json('PUT', 'api/products/' . $product->id)->assertStatus(422);
    }

    /**
     * Test status code when product not found on deleting
     * Should return 404 - 'Not Found'
     */
    public function test_throw_when_not_found_product_on_delete()
    {
        $this->json('DELETE', 'api/products/' . $this->nonExistentId)->assertStatus(404);
    }
}
