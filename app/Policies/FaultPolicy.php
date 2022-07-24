<?php

namespace App\Policies;

use App\Models\Fault;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaultPolicy
{
    use HandlesAuthorization;
    private $group_access_fault=array("admin","manager");

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_fault))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fault  $fault
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Fault $fault=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_fault))
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
        if(in_array($user_role,$this->group_access_fault))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fault  $fault
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Fault $fault=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_fault))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fault  $fault
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Fault $fault=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_fault))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fault  $fault
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Fault $fault)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fault  $fault
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Fault $fault)
    {
        //
    }
}
