<?php

namespace App\Policies;

use App\Models\ConsultantDefinitionDetail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantDefinitionDetailPolicy
{
    use HandlesAuthorization;
    private $group_access_consultant_definition_detail=array("admin","manager");

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_definition_detail))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantDefinitionDetail  $consultantDefinitionDetail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ConsultantDefinitionDetail $consultantDefinitionDetail=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_definition_detail))
            return true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_definition_detail))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantDefinitionDetail  $consultantDefinitionDetail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ConsultantDefinitionDetail $consultantDefinitionDetail)
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_definition_detail))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantDefinitionDetail  $consultantDefinitionDetail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ConsultantDefinitionDetail $consultantDefinitionDetail=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_consultant_definition_detail))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantDefinitionDetail  $consultantDefinitionDetail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ConsultantDefinitionDetail $consultantDefinitionDetail)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ConsultantDefinitionDetail  $consultantDefinitionDetail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ConsultantDefinitionDetail $consultantDefinitionDetail)
    {
        //
    }
}
