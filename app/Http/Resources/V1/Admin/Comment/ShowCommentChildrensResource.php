<?php

namespace App\Http\Resources\V1\Admin\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCommentChildrensResource extends JsonResource
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
            'user' => new CommentAuthorApiResource($this->user),
            'status' => $this->status == 1 ? 'NOT_APPROVED' : 'APPROVED',
            'body' => $this->body,
        ];
    }
}
