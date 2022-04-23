<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseStudentResource extends JsonResource
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
            "course_id" => $this->course_id,
            "student_id" => $this->student_id,
            "status" => $this->status,
            "user_id_created" => $this->user_id_created,
            "user_id_approved" =>  $this->user_id_approved,               
                           
        ];
    }
}
