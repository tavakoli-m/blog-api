<?php

namespace App\Http\Resources\V1\Admin\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCommentDatilsResource extends JsonResource
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
            'body' => $this->body,
            'user' => new CommentAuthorApiResource($this->user),
            'post' => new CommentPostApiResource($this->post),
            'status' => $this->status == 1 ? 'NOT_APPROVED' : 'APPROVED',
            'children' => ShowCommentChildrensResource::collection($this->children),
        ];
    }
}
