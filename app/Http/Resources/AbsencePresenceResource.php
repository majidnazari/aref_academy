<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsencePresenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        //return $this->resource;   
        if ($this->resource != null) { 
            return [ 
                "id" => $this->id !== null ? $this->id : null,
                "user" => new UserResource($this->user),
                "course_session" => new CourseSessionResource($this->courseSession),
                "teacher_id" => $this->teacher_id,            
                "status" =>$this->status           
            ];
        }
    }
}
