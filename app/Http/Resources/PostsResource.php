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
            'id' => (string)empty($this->id) ? (string)$this->ID : (string)$this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_date' => $this->created_at,
            'type' => $this->type,
            'attributes' => [
                'post_author' => $this->author_id,
                'slug' => $this->slug,

            ]
        ];
    }
}
