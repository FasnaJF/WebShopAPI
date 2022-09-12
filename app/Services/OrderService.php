<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private OrderRepositoryInterface $orderRepo;
    private ProductService $productService;
    private OrderProductService $orderProductService;

    public function __construct(OrderRepositoryInterface $orderRepo, OrderProductService $orderProductService)
    {
        $this->orderRepo = $orderRepo;
        $this->orderProductService = $orderProductService;
    }

    public function getOrderById($id)
    {
        return $this->orderRepo->getById($id);
    }

    public function createOrder($data)
    {
        $params = [];
        $params['user_id'] = Auth::user()->id;
        $params['paid'] = Order::STATUS_PENDING;
        $order = $this->orderRepo->create($params);
        if ($order) {
            $data['order_id'] = $order->id;
            $this->orderProductService->addOrderProducts($data);
            return $order;
        }

        return 'Order creation failed';
    }

    public function deleteOrder($id)
    {
        return $this->orderRepo->deleteById($id);
    }

    public function updateOrder($id, $data)
    {
        return $this->orderRepo->updateById($id, $data);
    }

    public function getAllOrders($request = null)
    {
        return $this->orderRepo->getAll($request);
    }
}
