<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    private $allowed_user=array("admin","financial");

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function getAllUser(User $user)
    {
        
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->allowed_user))
            return true;
        return false;
    }
}
