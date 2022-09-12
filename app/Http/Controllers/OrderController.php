<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseController
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
        if(!$order){
            return $this->sendError('Not found','Order not found',404);
        }
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $orderDetails = $request->validated();
        return $this->orderService->updateOrder($id, $orderDetails);
    }

    public function destroy($id)
    {
        return $this->orderService->deleteOrder($id);
    }
}
