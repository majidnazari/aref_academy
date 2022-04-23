<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            "name" => $this->name,
            "lesson" => $this->lesson,
            "type" => $this->type,
            "teacher" =>  $this->teacher_id,                 
            "year" =>  $this->year_id,                 
            "user" =>  $this->user_id,                 
        ];
    }
}
