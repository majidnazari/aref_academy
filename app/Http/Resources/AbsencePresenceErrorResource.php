<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsencePresenceErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $error;
    public function __Construct($req)
    {
       $this->error=$req;
    }
    public function toArray($request)
    {
        return [
                'success'   => false,
                'message'   => 'Validation errors',
                'details'      => $this->error,
                'code'      =>400                
              ];             
    }
}
