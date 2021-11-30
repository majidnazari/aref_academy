<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSessionResource extends JsonResource
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
            "user_id" =>$this->users_id,
            "course_id" => $this->courses_id,            
            "name" =>$this->name,
            "start_date" => $this->start_date,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,               
        ];
    }
}
