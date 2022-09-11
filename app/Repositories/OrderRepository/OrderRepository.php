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

    public function create(array $attributes)
    {
        return parent::create($attributes);
    }
}
