<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\StubOrder;
use Tests\StubProduct;
use Tests\StubUser;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;
    use StubUser;
    use StubOrder;
    use StubProduct;

    public function test_user_can_create_order()
    {
        $user = $this->createStubUser();
        $response = $this->actingAs($user)->post('/api/orders', [
            'products' => [
                ["id" => 12, "quantity" => 5],
                ["id" => 92, "quantity" => 1],
                ["id" => 2, "quantity" => 10]
            ],
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_see_orders()
    {
        $user = $this->createStubUser();
        $response = $this->actingAs($user)->get('/api/orders');
        $response->assertStatus(200);
    }

    public function test_user_can_see_an_order()
    {
        $user = $this->createStubUser();
        $order = $this->createStubOrder($user);
        $response = $this->actingAs($user)->get('/api/orders/'.$order->id);
        $response->assertStatus(200);
    }

    public function test_user_cannot_see_another_users_order()
    {
        $user1 = $this->createStubUser();
        $user2 = $this->createStubUser();
        $order = $this->createStubOrder($user1);
        $response = $this->actingAs($user2)->get('/api/orders/'.$order->id);
        $response->assertStatus(403);
    }

    public function test_user_can_update_an_order()
    {
        $user = $this->createStubUser();
        $order = $this->createStubOrder($user);
        $response = $this->actingAs($user)->patch('/api/orders/'.$order->id,['paid'=>Order::STATUS_CANCELLED]);
        $response->assertStatus(200);
    }

    public function test_user_cannot_update_another_users_order()
    {
        $user1 = $this->createStubUser();
        $order = $this->createStubOrder($user1);
        $user2 = $this->createStubUser();
        $response = $this->actingAs($user2)->patch('/api/orders/'.$order->id,['paid'=>Order::STATUS_CANCELLED]);
        $response->assertStatus(403);
    }

    public function test_user_can_delete_an_order()
    {
        $user = $this->createStubUser();
        $order = $this->createStubOrder($user);
        $response = $this->actingAs($user)->delete('/api/orders/'.$order->id);
        $response->assertStatus(200);
    }

    public function test_user_cannot_delete_another_users_order()
    {
        $user1 = $this->createStubUser();
        $order = $this->createStubOrder($user1);
        $user2 = $this->createStubUser();
        $response = $this->actingAs($user2)->delete('/api/orders/'.$order->id);
        $response->assertStatus(403);
    }

    public function test_user_can_add_product_to_an_order()
    {
        $user = $this->createStubUser();
        $order = $this->createStubOrder($user);
        $product = $this->createStubProduct();
        $response = $this->actingAs($user)->post('/api/orders/'.$order->id.'/add',['product_id'=>$product->id]);
        $response->assertStatus(200);
    }

    public function test_user_cannot_add_product_to_another_users_order()
    {
        $user1 = $this->createStubUser();
        $order = $this->createStubOrder($user1);
        $product = $this->createStubProduct();
        $user2 = $this->createStubUser();
        $response = $this->actingAs($user2)->post('/api/orders/'.$order->id.'/add',['product_id'=>$product->id]);
        $response->assertStatus(403);
    }

    public function test_user_can_pay_for_an_order()
    {
        $user = $this->createStubUser();
        $order = $this->createStubOrder($user);
        $response = $this->actingAs($user)->post('/api/orders/'.$order->id.'/pay');
        $response->assertStatus(200);
    }

    public function test_user_cannot_pay_for_another_users_order()
    {
        $user1 = $this->createStubUser();
        $order = $this->createStubOrder($user1);
        $product = $this->createStubProduct();
        $user2 = $this->createStubUser();
        $response = $this->actingAs($user2)->post('/api/orders/'.$order->id.'/pay');
        $response->assertStatus(403);
    }
}
