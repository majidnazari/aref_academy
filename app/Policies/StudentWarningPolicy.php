<?php

namespace App\Policies;

use App\Models\StudentWarning;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentWarningPolicy
{
    use HandlesAuthorization;
    private $group_access_student_warning_history=array("admin","financial");

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
       return $this->get_accessibility();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentWarning  $studentWarning
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, StudentWarning $studentWarning=null):bool
    {
       return $this->get_accessibility();
       
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user):bool
    {
       return $this->get_accessibility();
        
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentWarning  $studentWarning
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, StudentWarning $studentWarning=null):bool
    {
        return $this->get_accessibility();
       
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentWarning  $studentWarning
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, StudentWarning $studentWarning=null):bool
    {
       return $this->get_accessibility();
        
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentWarning  $studentWarning
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, StudentWarning $studentWarning)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentWarning  $studentWarning
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, StudentWarning $studentWarning)
    {
        //
    }
    public function get_accessibility()
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_student_warning_history))
            return true;
        return false;
    }
}
