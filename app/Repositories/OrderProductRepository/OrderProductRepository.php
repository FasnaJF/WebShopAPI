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

    public function getByOrderDetails($data)
    {
        $orderProduct =  $this->model->where([['order_id',$data['order_id']],['product_id',$data['product_id']]])->first();
        if(!$orderProduct){
            return false;
        }
        return $orderProduct;
    }
}
