<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'sku'     => $this->sku,
            'barcode' => $this->barcode,
            'price'   => $this->price
        ];
    }
}
