<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ID' => (string)$this->ID,
            'type' => 'Posts',
            'attributes' => [
                'post_author' => $this->author_id,
                'title' => $this->title,
                'content' => $this->content,
                'created_date' => $this->created_at
            ]
        ];
    }
}
