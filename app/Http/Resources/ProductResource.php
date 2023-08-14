<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->category_id,
            'category' => $this->when(
                $request->get('relationships'),
                new CategoryResource($this->whenLoaded('category'))
            ),
            'code' => $this->code,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'storage' => $this->storage,
        ];
    }
}
