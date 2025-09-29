<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_view_product_details()
    {
        $product = Product::factory()->create([
            'name' => 'Sofa Set',
            'price' => 12000,
        ]);

        $response = $this->get('/shop/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee((string)$product->price);
    }
}
