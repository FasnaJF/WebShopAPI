<?php

namespace App\Services;

use App\Repositories\OrderProductRepository\OrderProductRepositoryInterface;

class OrderProductService
{
    private OrderProductRepositoryInterface $OrderProductRepo;
    private ProductService $productService;

    public function __construct(OrderProductRepositoryInterface $OrderProductRepo, ProductService $productService)
    {
        $this->OrderProductRepo = $OrderProductRepo;
        $this->productService = $productService;
    }

    public function getOrderProductById($id)
    {
        return $this->OrderProductRepo->getById($id);
    }

    public function addOrderProducts($data)
    {
        $orderProduct = [];
        foreach (json_decode($data['products']) as $product) {
            $orderProduct['order_id'] = $data['order_id'];
            $orderProduct['product_id'] = $product->id;
            $orderProduct['quantity'] = $product->quantity > 0 ? $product->quantity : 1;
            $this->createOrderProduct($orderProduct);
        }
        return true;
    }

    public function deleteOrderProduct($id)
    {
        return $this->OrderProductRepo->deleteById($id);
    }

    public function updateOrderProduct($id, $data)
    {
        return $this->OrderProductRepo->updateById($id, $data);
    }

    public function addOrderProduct($data)
    {
        $orderProduct = $this->OrderProductRepo->getByOrderDetails($data);
        if ($orderProduct) {
            return $this->updateOrderProduct($orderProduct->id, ['quantity' => ($orderProduct->quantity) + 1]);
        }
        $data['quantity'] = 1;
        return $this->createOrderProduct($data);
    }

    public function createOrderProduct($data)
    {
        $productDetails = $this->productService->getProductById($data['product_id']);
        if (!$productDetails) {
            return false;
        }
        return $this->OrderProductRepo->create($data);
    }


}
