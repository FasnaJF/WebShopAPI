<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateOrderRequest extends BaseRequest
{
    public function authorize()
    {
        if (\auth()->user()) {
            return true;
        } else {
            return $this->unauthorizedError();
        }
    }

    public function rules()
    {
        return [
            'paid' => 'required|string',
        ];
    }
}
