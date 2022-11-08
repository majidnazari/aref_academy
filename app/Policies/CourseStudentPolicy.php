<?php

namespace App\Policies;

use App\Models\CourseStudent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

use Log;

class CourseStudentPolicy
{
    use HandlesAuthorization;
    private $group_access_course_student=array("admin","manager","financial","acceptor");

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_course_student))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CourseStudent $courseStudent=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_course_student))
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
        if(in_array($user_role,$this->group_access_course_student))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, $request ):bool
    {
        $refused_status=isset($request['financial_refused_status']) ? $request['financial_refused_status'] : "" ;
        //Log::info("the all fields are:" . $refused_status );
        if($refused_status != ""){
            $group_access_course_student_financial_refused_status=array("financial");
           return  $this->get_accessibility($group_access_course_student_financial_refused_status);
           
        }
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_course_student))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CourseStudent $courseStudent=null):bool
    {
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$this->group_access_course_student))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CourseStudent $courseStudent=null)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CourseStudent $courseStudent)
    {
        //
    }
    public function get_accessibility($array_accessibility=null)
    {
        if($array_accessibility==null){
            $array_accessibility=$this->group_access_course_student;
        }
        $user_role=auth()->guard('api')->user()->group->type;       
        if(in_array($user_role,$array_accessibility))
            return true;
        return false;
    }
}
