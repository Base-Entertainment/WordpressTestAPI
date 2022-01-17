<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'id' => empty($this->id) ? $this->ID : $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'post_date' => $this->post_date,
            'format' => $this->getFormat() ? Str::lower($this->getFormat()) : 'article',
            'author' => $this->author_id,
            'categories' => CategoryResource::collection($this->taxonomies()->category()->get()),
            'thumbnail' => $this->image
        ];
    }
}
