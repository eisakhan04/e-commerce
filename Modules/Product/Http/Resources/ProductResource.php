<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Http\Resources\CategoryResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount_price' => $this->discount_price ? (float) $this->discount_price : null,
            'cost_price' => $this->cost_price ? (float) $this->cost_price : null,
            'stock' => $this->stock,
            'min_stock_alert' => $this->min_stock_alert,
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'weight' => (float) $this->weight,
            'status' => $this->status,
            'featured' => (bool) $this->featured,
            'views' => $this->views,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
