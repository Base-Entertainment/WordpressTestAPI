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
            'ID' => $this->ID, // ID
            'userID' => $this->login, // user_login
            'email' => $this->email, // user_email
            'nickname' => $this->nickname, // (meta) nickname
            'firstname' => $this->first_name, // (meta) first_name
            'lastname' => $this->last_name, // (meta) last_name
            'displayname' => $this->displayname,
            'role' => $this->capabilities, // (meta) wp_capabilities 
            'slug' => $this->slug, //slug

        ];
    }
}
