<?php

namespace App\AuthFacade;
use App\Models\User;

class CheckAuth
{
    public function GetRole(int $user_id){
        $user_group=User::where('deleted_at',null)
        ->whereHas('group', function($query) use($user_id) {
           // $q->where('group_id','=',1)
            $query->where('user_id',$user_id); 
        }) 
        ->first();
        if($user_group)
        {
            return $user_group->group[0]->type;
        }
        return "there is no type for this user";

    }
} 