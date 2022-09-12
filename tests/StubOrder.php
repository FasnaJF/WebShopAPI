<?php

namespace Tests;

use App\Models\Order;

trait StubOrder
{
    protected Order $order;

    public function createStubOrder($user)
    {
        $order = Order::create([
            'products' => [
                ["id" => 12, "quantity" => 5],
                ["id" => 92, "quantity" => 1],
                ["id" => 2, "quantity" => 10]
            ],
            'user_id'=>$user->id,
            'paid' => Order::STATUS_PENDING,
        ]);
        return $this->order = $order;
    }
}
