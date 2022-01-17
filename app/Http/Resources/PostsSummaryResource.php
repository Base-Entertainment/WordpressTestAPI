<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostsSummaryResource extends JsonResource{

    public function toArray($request)
    {
        return [
            'id' => empty($this->id) ? $this->ID : $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'post_date' => $this->post_date,
            'format' => $this->getFormat() ? Str::lower($this->getFormat()) : 'article',
            'author' => $this->author_id,
            'categories' => CategoryResource::collection($this->taxonomies()->category()->get()),
            'thumbnail' => $this->image
        ];
    }
}
