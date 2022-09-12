<?php

namespace Tests;

use App\Models\Product;

trait StubProduct
{
    protected Product $product;

    public function createStubProduct(array $data = [])
    {
        $product = Product::create([
            'product_name'=> 'Test product',
            'price'=>5.76,
        ]);
        return $this->product = $product;
    }
}
