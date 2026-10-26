<?php

namespace App\Http\Resources\V1\Admin\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'body' => $this->body,
            'slug' => $this->slug,
            'author' => new PostAutherDetailApiResource($this->author),
            'category' => new PostCategoryDetailApiResource($this->category),
            'status' => $this->status == 1 ? 'ACTIVE' : 'INACTIVE',
            'published_at' => $this->published_at ?? null
        ];
    }
}
