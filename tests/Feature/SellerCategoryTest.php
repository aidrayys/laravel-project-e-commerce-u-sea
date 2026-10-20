<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function loginAsSeller(): void
    {
        $this->post('/seller/login', ['username' => 'pesisirrasa', 'password' => '123'])
            ->assertRedirect('/seller/dashboard');
    }

    protected function createCategory(string $name): Category
    {
        return Category::create(['name' => $name]);
    }

    public function test_seller_category_routes_are_protected(): void
    {
        $this->get('/seller/categories')->assertRedirect('/seller/login');
        $this->get('/seller/categories/create')->assertRedirect('/seller/login');
    }

    public function test_seller_can_view_category_list(): void
    {
        $this->loginAsSeller();

        $category = $this->createCategory('Fresh Fish');
        Product::create([
            'name' => 'Test Product',
            'description' => 'Test description',
            'price' => 50000,
            'stock' => 10,
            'category' => $category->name,
            'category_id' => $category->id,
            'seller_name' => 'Pesisir Rasa',
            'location' => 'Lamongan',
        ]);

        $response = $this->get('/seller/categories');
        $response->assertStatus(200)
                 ->assertViewIs('seller.categories.index')
                 ->assertSee('Fresh Fish')
                 ->assertSee('1');
    }

    public function test_seller_can_create_category(): void
    {
        $this->loginAsSeller();

        $response = $this->post('/seller/categories', [
            'name' => 'New Category',
        ]);

        $response->assertRedirect('/seller/categories');
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    public function test_category_name_must_be_unique(): void
    {
        $this->loginAsSeller();
        $this->createCategory('Existing Category');

        $response = $this->post('/seller/categories', [
            'name' => 'Existing Category',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_seller_can_update_category(): void
    {
        $this->loginAsSeller();
        $category = $this->createCategory('Old Name');

        $response = $this->patch("/seller/categories/{$category->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertRedirect('/seller/categories');
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Name']);
        $this->assertDatabaseMissing('categories', ['name' => 'Old Name']);
    }

    public function test_seller_cannot_delete_category_with_products(): void
    {
        $this->loginAsSeller();
        $category = $this->createCategory('Used Category');
        Product::create([
            'name' => 'Product in Category',
            'description' => 'Test description',
            'price' => 50000,
            'stock' => 10,
            'category' => $category->name,
            'category_id' => $category->id,
            'seller_name' => 'Pesisir Rasa',
            'location' => 'Lamongan',
        ]);

        $response = $this->delete("/seller/categories/{$category->id}");

        $response->assertRedirect('/seller/categories')
                 ->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_seller_can_delete_empty_category(): void
    {
        $this->loginAsSeller();
        $category = $this->createCategory('Empty Category');

        $response = $this->delete("/seller/categories/{$category->id}");

        $response->assertRedirect('/seller/categories')
                 ->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
