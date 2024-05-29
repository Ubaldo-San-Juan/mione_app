<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'type' => 'posts',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->title,
                'message' => $this->message,
                'slug' => $this->slug,
                'create_at' => (new Carbon($this->created_at))->format('d-m-y H:i:s'),
                'update_at' => $this->updated_at
            ],
            'links' => [
                'self' => route('api.posts.show', $this->resource)
            ],
            'relationships' =>[
                'user' => new UserResource($this->whenLoaded('user')),
                'comments' => new CommentResource($this->whenLoaded('comments'))
            ]
        ];
    }
}
