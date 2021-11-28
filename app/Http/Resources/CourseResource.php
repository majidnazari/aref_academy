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
            "teachers" =>  $this->teachers_id,                 
            "years" =>  $this->years_id,                 
            "users" =>  $this->users_id,                 
        ];
    }
}
