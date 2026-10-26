<?php

namespace App\Http\Resources\V1\Admin\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentApiResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comments' => CommentApiResource::collection($this->collection),
            'meta' => [
                'last_page' => $this->lastPage()
            ]
        ];
    }
}
