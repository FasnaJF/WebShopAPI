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

    public function createOrderProduct($data)
    {
        $orderProduct = [];
        foreach (json_decode($data['products']) as $product) {
            $productDetails = $this->productService->getProductById($product->id);
            if (!$productDetails) {
                return 'Invalid product id: ' . $product->id;
            }

            $orderProduct['order_id'] = $data['order_id'];
            $orderProduct['product_id'] = $product->id;
            $orderProduct['quantity'] = $product->quantity > 0 ? $product->quantity : 1;
            $this->OrderProductRepo->create($orderProduct);
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

}
