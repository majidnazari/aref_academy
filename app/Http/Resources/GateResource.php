<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GateResource extends JsonResource
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
            "id" => $this->id,
            "users_id" => $this->users_id,
            "name" => $this->name,
            "description" => $this->description                            
        ];
    }
}
