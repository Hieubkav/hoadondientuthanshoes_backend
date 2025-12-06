<?php

namespace App\Http\Resources;

class InvoiceResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'seller_tax_code' => $this->seller_tax_code,
            'invoice_code' => $this->invoice_code,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
