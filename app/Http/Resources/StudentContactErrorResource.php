<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentContactErrorResource extends JsonResource
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
       //dd($err["name"]);
    }
    public function toArray($request)
    {
       // dd($this->err["name"]);
     //   dd($request);
        return [
                'success'   => false,
                'message'   => 'Validation errors',
                'details'      => $this->error,
                'code'      =>400                
              ];             
    }
}
