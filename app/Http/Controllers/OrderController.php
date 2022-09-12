<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderProductRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\OrderProductService;
use App\Services\OrderService;

class OrderController extends BaseController
{

    private OrderService $orderService;
    private OrderProductService $orderProductService;

    public function __construct(OrderService $orderService, OrderProductService $orderProductService)
    {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return new OrderCollection($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $orderDetails = $request->validated();
        $order = $this->orderService->createOrder($orderDetails);
        return new OrderResource($order);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        if (!$order) {
            return $this->sendError('Not found', 'Order not found', 404);
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

    public function addProduct(AddOrderProductRequest $request)
    {
        $orderDetails = $request->validated();
        $orderDetails['order_id'] = $request->id;
        $orderStatus = $this->orderService->getOrderById($request->id)['paid'];

        if ($orderStatus != 0) {
            return $this->sendError('Denied', 'You cannot edit a order which is processed already', 500);
        }

        $orderProduct = $this->orderProductService->addOrderProduct($orderDetails);
        if ($orderProduct) {
            $order = $this->orderService->getOrderById($orderProduct->order_id);
            return new OrderResource($order);
        }

        return $this->sendError('Not found', 'Product not found', 404);
    }
}
