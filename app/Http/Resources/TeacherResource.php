<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$request=parent::toArray($request);
        //return parent::toArray($request);
        //dd ( $this->resource[0]["first_name"]);
        // if($this->resource!=null)
        // {
        //     return [
        //         'first_name' => $this->resource[0]["first_name"],
        //         'last_name' =>$this->resource[0]["last_name"],
        //         'mobile' =>$this->resource[0]["mobile"],
        //         'address' =>$this->resource[0]["address"],
        //         'user_id' =>$this->resource[0]["user_id"]
        //     ];
        // }
        if($this->resource!=null)
        {
            return [
                'first_name' => $this->first_name,
                'last_name' =>$this->last_name,
                'mobile' =>$this->mobile,
                'address' =>$this->address,
                'user_id' =>$this->user_id
            ];
        }
      
    }
}
