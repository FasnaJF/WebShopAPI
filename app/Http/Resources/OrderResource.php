<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'paid' => $this->paid,
            'products' => $this->orderProducts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
