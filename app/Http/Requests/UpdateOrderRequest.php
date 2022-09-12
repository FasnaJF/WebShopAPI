<?php

namespace App\Http\Requests;

use function auth;

class UpdateOrderRequest extends BaseRequest
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
            'paid' => 'required|string',
        ];
    }
}
