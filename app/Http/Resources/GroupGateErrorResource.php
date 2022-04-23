<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupGateErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $error;
    public function __Construct($request)
    {
        $this->error=$request;
    }
    public function toArray($request)
    {
        return 
        [
            'success'   => false,
            'message'   => 'Validation errors',
            'details'      => $this->error,
            'code'      =>400 

        ];
    }
}
