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
        // dd($request->get('relationships'));
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => $this->whenRelationship(
                $request,
                'category',
                new CategoryResource($this->whenLoaded('category'))
            ),
            'code' => $this->code,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'storage' => $this->storage,
            'images' => $this->whenRelationship(
                $request,
                'images',
                ProductImageResource::collection($this->whenLoaded('images'))
            ),
        ];
    }

   private function whenRelationship($request, $relation, $data)
   {
        $relations = explode("-", $request->get('relationships'));
        
        return $this->when(
            in_array($relation, $relations),
            $data
        );
   }
   
}
