<?php

namespace App\Services;

use App\Repositories\OrderProductRepository\OrderProductRepositoryInterface;

class OrderProductService
{
    private OrderProductRepositoryInterface $OrderProductRepo;

    public function __construct(OrderProductRepositoryInterface $OrderProductRepo)
    {
        $this->OrderProductRepo = $OrderProductRepo;
    }

    public function getOrderProductById($id)
    {
        return $this->OrderProductRepo->getById($id);
    }

    public function createOrderProduct($data)
    {
        return $this->OrderProductRepo->create($data);
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
