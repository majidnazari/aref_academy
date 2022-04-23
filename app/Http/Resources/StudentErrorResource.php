<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $error;
    public $code;
    public function __Construct($req,$code)
    {
       $this->error=$req;     
       $this->code=$code;     
    }
    public function toArray($request)
    {      
        return [
                'success'   => false,
                'message'   => 'errors',
                'details'      => $this->error,
                'code'      =>$this->code                
              ];             
    }
}
