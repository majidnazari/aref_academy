<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AzmoonResource extends JsonResource
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
            "user_id" => $this->user_id,
            "course_id" => $this->course_id,
            "course_session_id" => $this->course_session_id,
            "isSMSsend" =>  $this->isSMSsend,                 
            "score" =>  $this->score,                
               ];
    }
}
