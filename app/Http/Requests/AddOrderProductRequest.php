<?php

namespace App\Http\Requests;

use function auth;

class AddOrderProductRequest extends BaseRequest
{
    public function authorize()
    {
        if (auth()->user()) {
            return true;
        } else {
            return $this->unauthorizedError();
        }
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer',
        ];
    }
}
