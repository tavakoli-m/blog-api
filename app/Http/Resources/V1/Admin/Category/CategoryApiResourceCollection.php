<?php

namespace App\Http\Resources\V1\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryApiResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categories' => CategoryApiResource::collection($this->collection),
            'meta' => [
                'last_page' => $this->lastPage()
            ]
        ];
    }
}
