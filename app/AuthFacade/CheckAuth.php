<?php

namespace App\AuthFacade;
use App\Models\User;

class CheckAuth
{
    private $group_access_absence_presence=array("admin");
    public function CheckAccessibility(){
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_absence_presence))
            return true;
        return false;
    }

   
    // public function GetRole(int $user_id){
    //     $user_group=User::where('deleted_at',null)
    //     ->whereHas('group', function($query) use($user_id) {
    //        // $q->where('group_id','=',1)
    //         $query->where('user_id',$user_id); 
    //     }) 
    //     ->first();
    //     if($user_group)
    //     {
    //         return $user_group->group->type;
    //     }
    //     return "there is no type for this user";

    // }
} 