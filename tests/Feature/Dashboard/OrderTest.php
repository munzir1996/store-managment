<?php

namespace Tests\Feature\Dashboard;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_an_order()
    {
        // $this->withExceptionHandling();
        $user = $this->login();
        $product = factory(Product::class, 2)->create([
            'added_value' => 0,
            'deducted_value' => 0,
            'total_price' => 10,
        ]);

        $orderDetails = [
            [
                'product_id' => $product[0]->id,
                'quantity' => 1,
            ],
            [
                'product_id' => $product[1]->id,
                'quantity' => 1,
            ],
        ];

        $response = $this->post('/dashboard/orders', [
            'customer_phone' => '0114949901',
            'customer_alt_phone' => '0994989901',
            'customer_address' => 'customer_address',
            'discount' => 5,
            'orderDetails' => $orderDetails,
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_phone' => '0114949901',
            'customer_alt_phone' => '0994989901',
            'customer_address' => 'customer_address',
            'discount' => 5,
            'total_price' => 15,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $product[0]->id,
            'quantity' => 1,
        ]);

    }

    /** @test */
    public function admin_can_approve_an_order()
    {
        // $this->withExceptionHandling();
        $user = $this->login();
        $order = factory(Order::class)->create([
            'total_price' => 10,
        ]);

        $response = $this->put('/dashboard/approve/orders/'. $order->id , [
            'added_price' => 10,
            'delivery_price' => 30,
            'delivery_man_id' => $user->id,
        ]);

        $this->assertDatabaseHas('orders', [
            'added_price' => 10,
            'delivery_price' => 30,
            'delivery_man_id' => $user->id,
            'total_price' => 50,
        ]);

    }

}






