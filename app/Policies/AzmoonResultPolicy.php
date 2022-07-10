<?php

namespace App\Policies;

use App\Models\AzmoonResult;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AzmoonResultPolicy
{
    use HandlesAuthorization;
    private $group_access_azmoon_result=array("admin");
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_azmoon_result))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AzmoonResult  $azmoonResult
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AzmoonResult $azmoonResult=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_azmoon_result))
            return true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_azmoon_result))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AzmoonResult  $azmoonResult
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AzmoonResult $azmoonResult=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_azmoon_result))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AzmoonResult  $azmoonResult
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AzmoonResult $azmoonResult=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_azmoon_result))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AzmoonResult  $azmoonResult
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AzmoonResult $azmoonResult)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AzmoonResult  $azmoonResult
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AzmoonResult $azmoonResult)
    {
        //
    }
}
