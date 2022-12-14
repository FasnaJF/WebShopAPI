<?php

namespace App\Repositories\OrderRepository;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function updateById($id, array $params)
    {
        $order = $this->getById($id);
        if (! $order) {
            return 'Order not found';
        }
        return parent::updateById($id, $params);
    }
}
