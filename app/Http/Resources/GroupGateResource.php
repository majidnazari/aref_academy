<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupGateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "group_id" => $this->group_id,
            "gate_id" => $this->gate_id,
            "name" => $this->name,
        ];
    }
}
