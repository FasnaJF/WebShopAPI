<?php

namespace App\Http\Requests;

use function auth;

class CreateOrderRequest extends BaseRequest
{
    public function authorize()
    {
        if (auth()->user()) {
            return true;
        }
        return $this->unauthorizedError();
    }

    public function rules()
    {
        return [
            'products' => 'required|json',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->request->has('products')){
            $this->merge([
                'products' => json_encode($this->products),
            ]);
        }
    }
}
