<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => (string)$this->name,
            'slug' => (string)$this->slug,
            'active' => (bool)$this->active,
            'code' => (string)$this->code,
            'barcode' => (string)$this->barcode,
            'description' => (string)$this->description,
            'price' => (int)$this->price,
            'price_decimals' => (string)$this->price,
            'created_at' => (string)$this->created_at,
        ];
    }
}
