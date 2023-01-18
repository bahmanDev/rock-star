<?php

namespace Tests\Feature\Order;

use App\Models\Option;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OrderCreateTest extends TestCase
{
    /**
     *
     * @test
     */
    public function user_can_make_order()
    {
        $products = Product::factory(5)->create();

        $data = [];
        $totalPrice = 0;
        foreach ($products as $key => $product){
            $option = Option::factory(3)->create(['product_id' => $product->id]);
            $data[$key]['product_id'] = $product->id;
            $data[$key]['qty'] = rand(1, 3);
            $data[$key]['option_id'] = $option[0]->id;
            $totalPrice += $data[$key]['qty'] *$product->price;
        }

        $this->userCreateAndLogin();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('orders.store'), [
            'orders' => $data
        ]);

        $this->assertEquals($response->json('result.total_price'), $totalPrice);

        $response->assertStatus(200);
    }

    public function userCreateAndLogin(): void
    {
        $user = User::create([
            'name' => 'Iman',
            'email' => 'iman@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $this->post(route('login'), [
                'email' => $user->email,
                'password' => 'password'
            ]
        )->assertOk();

        $this->assertAuthenticated();
    }
}
