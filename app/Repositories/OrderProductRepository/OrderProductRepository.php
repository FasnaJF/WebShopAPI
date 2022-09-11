<?php

namespace App\Repositories\OrderProductRepository;

use App\Models\OrderProduct;
use App\Repositories\BaseRepository;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    public function __construct(OrderProduct $orderProduct)
    {
        $this->model = $orderProduct;
    }
}
