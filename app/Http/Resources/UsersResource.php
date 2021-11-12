<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UsersResource extends JsonResource
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
            'ID' => $this->ID,
            'userID' => $this->login,
            'email' => $this->email,
            'slug' => $this->slug,
            'role' => $this->capabilities
        ];
    }
}
