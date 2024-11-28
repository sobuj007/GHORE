<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "vendor_id" => $this->vendor_id,
            "product_quantity" => $this->product_quantity,
            "product_price" => $this->product_price,
            "service_quantity" => $this->service_quantity,
            "service_price" => $this->service_price,
            "userreqtime" => $this->userreqtime,
            "req_order_date" => $this->req_order_date,
            "payable" => $this->payable,
            "status" => $this->status,
            "user" => $this->order->user,
            "service_product" => $this->serviceProduct
        ];
    }
}