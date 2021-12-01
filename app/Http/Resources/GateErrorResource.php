<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GateErrorResource extends JsonResource
{
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
