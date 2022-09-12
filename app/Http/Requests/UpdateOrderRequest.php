<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Validation\Rule;

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
            'paid' => ['required', 'string', Rule::in([Order::STATUS_PAID,Order::STATUS_PENDING,Order::STATUS_CANCELLED]),],
        ];
    }
}
