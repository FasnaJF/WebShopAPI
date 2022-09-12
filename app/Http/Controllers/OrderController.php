<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderProductRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderProductService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    private OrderService $orderService;
    private OrderProductService $orderProductService;
    private PaymentService $paymentService;

    public function __construct(
        OrderService $orderService,
        OrderProductService $orderProductService,
        PaymentService $paymentService
    ) {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
        $this->paymentService = $paymentService;
        $this->authorizeResource(Order::class);
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

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $orderDetails = $request->validated();
        return $this->orderService->updateOrder($order->id, $orderDetails);
    }

    public function destroy(Order $order)
    {
        return $this->orderService->deleteOrder($order->id);
    }

    public function addProduct(AddOrderProductRequest $request)
    {
        $orderDetails = $request->validated();
        $orderDetails['order_id'] = $request->id;
        $order = $this->orderService->getOrderById($request->id);
        if ($order->user_id !== Auth::id()) {
            return $this->sendError('Denied', 'You are not authorized to update this order', 403);
        }
        $orderStatus = $order['paid'];

        if ($orderStatus !== Order::STATUS_PENDING) {
            return $this->sendError('Denied', 'You cannot edit a order which is processed already', 500);
        }

        $orderProduct = $this->orderProductService->addOrderProduct($orderDetails);
        if ($orderProduct) {
            $order = $this->orderService->getOrderById($orderProduct->order_id);
            return new OrderResource($order);
        }

        return $this->sendError('Not found', 'Product not found', 404);
    }

    public function makePayment(Request $request)
    {
        return $this->paymentService->createPayment($request);
    }
}
