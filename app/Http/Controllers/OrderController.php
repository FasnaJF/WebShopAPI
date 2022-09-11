<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return new OrderCollection($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $orderDetails = $request->validated();
        return $this->orderService->createOrder($orderDetails);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        return new OrderResource($order);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
