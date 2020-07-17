<?php

namespace Tests\Feature\Dashboard;

use App\Product;
use App\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_product()
    {
        // $this->withExceptionHandling();
        $this->login();

        $subcategory = factory(Subcategory::class)->create();

        $this->post('dashboard/products', [
            'name' => 'name',
            'weight' => 5,
            'category_id' => $subcategory->category->id,
            'subcategory_id' => $subcategory->id,
            'added_value' => 5,
            'deducted_value' => 5,
            'code' => '123',
            'stock' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'name',
            'weight' => 5,
            'category_id' => $subcategory->category->id,
            'subcategory_id' => $subcategory->id,
            'added_value' => 5,
            'deducted_value' => 5,
            'code' => '123',
            'stock' => 5,
        ]);

    }

    /** @test */
    public function can_edit_product()
    {
        // $this->withExceptionHandling();
        $this->login();

        $product = factory(Product::class)->create();

        $this->put('dashboard/products/'. $product->id, [
            'name' => 'name',
            'weight' => 5,
            'category_id' => $product->category->id,
            'subcategory_id' => $product->subcategory->id,
            'added_value' => 5,
            'deducted_value' => 5,
            'code' => '123',
            'stock' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'name',
            'weight' => 5,
            'category_id' => $product->category->id,
            'subcategory_id' => $product->subcategory->id,
            'added_value' => 5,
            'deducted_value' => 5,
            'code' => '123',
            'stock' => 5,
        ]);

    }

    /** @test */
    public function can_delete_product(){

        // $this->withExceptionHandling();
        $this->login();

        $product = factory(Product::class)->create();

        $this->delete('dashboard/products/'. $product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

    }

}


