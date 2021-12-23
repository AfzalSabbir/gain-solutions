<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'title'            => $this->title,
            'category'         => new CategoryResource($this->category),
            'product_variants' => ProductVariantResource::collection($this->productVariants),
        ];
    }
}
