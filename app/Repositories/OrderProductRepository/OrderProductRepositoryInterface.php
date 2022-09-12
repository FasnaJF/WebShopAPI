<?php

namespace App\Repositories\OrderProductRepository;

use App\Repositories\BaseRepositoryInterface;

interface OrderProductRepositoryInterface extends BaseRepositoryInterface
{

    public function getByOrderDetails($data);
}
