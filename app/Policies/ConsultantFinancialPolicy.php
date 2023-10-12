<?php

namespace App\Policies;

use App\Models\ConsultantFinancial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;

class ConsultantFinancialPolicy
{
    use HandlesAuthorization;  
    private $group_access_consultant_financial=array("admin","manager","consultant_manager");
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {        
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_financial))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantFinancial  $consultantFinancial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ConsultantFinancial $consultantFinancial=null):bool
    {       
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_financial))
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
        //Log::info("ddfsfd");      
        $user_role=auth()->guard('api')->user()->group->type;      

        if(in_array($user_role,$this->group_access_consultant_financial))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantFinancial  $consultantFinancial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ConsultantFinancial $consultantFinancial=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_financial))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantFinancial  $consultantFinancial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ConsultantFinancial $consultantFinancial=null):bool
    {       
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_financial))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantFinancial  $consultantFinancial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ConsultantFinancial $consultantFinancial)
    {  
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantFinancial  $consultantFinancial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ConsultantFinancial $consultantFinancial)
    {
          //
    }
}
