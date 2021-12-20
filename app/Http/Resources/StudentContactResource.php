<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentContactResource extends JsonResource
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
            "student_id" => $this->student_id,
            "absence_presence_id" => $this->absence_presence_id,                          
            "who_answered" => $this->who_answered,                          
            "description" => $this->description,                          
            "is_called_successfull" => $this->is_called_successfull,                          
        ];        
    }
}
