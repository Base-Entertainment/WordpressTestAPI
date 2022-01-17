<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorySummaryResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->term_id,
            'name' => $this->term->name,
            'count' => $this->posts->count()
        ];
    }
}
