<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_add_new_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Wooden Chair',
            'category_id' => $category->id,
            'price' => 3500,
            'quantity' => 10,
            'description' => 'A comfortable wooden chair',
            'is_active' => true,
        ]);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', ['name' => 'Wooden Chair']);
    }
}
