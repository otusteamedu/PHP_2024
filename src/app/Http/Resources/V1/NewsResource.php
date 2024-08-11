<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
//    public static $wrap = 'news';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'news',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'body' => $this->when(
                    $request->routeIs('news.show'),
                    $this->body
                ),
                'category' => $this->category,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id
                    ],
//                    'links' => [
//                        'self' => route('authors.show', ['author' => $this->user_id])
//                    ]
                ]
            ],
            'includes' => new UserResource($this->whenLoaded('author')),
//            'links' => [
//                'self' => route('news', ['news' => $this->id])
//            ],
        ];
    }
}
