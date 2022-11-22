<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use AuthRole;
use GraphQL\Error\Error;
use Log;

final class GetCourseStudents
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        // $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        // //Log::info("the b are:" . json_encode($branch_ids));
        // $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;

        $branch_id = auth()->guard('api')->user()->branch_id;

        //Log::info("the branche id is" .  count($branch_id));
        // $CourseStudent = CourseStudent::where('deleted_at', null);
        // return $CourseStudent;
        //Log::info("the status is: " .$args['manager_financial_not_equal']);
        if (AuthRole::CheckAccessibility("CourseStudent")) {
            //$CourseStudent= CourseStudent::where('deleted_at', null);//->orderBy('id','desc');
            $CourseStudent = CourseStudent::where('deleted_at', null)               
                ->whereHas('course', function ($query) use ($branch_id) {
                    if($branch_id){
                        $query->where('branch_id',$branch_id);
                    }  
                     return true;
                })->with('course')
                ->where(function ($query) use ($args) {
                    if (isset($args['manager_financial_not_equal'])) {
                        $query->where('course_students.manager_status', '!=', $args['manager_financial_not_equal'])
                            ->orwhere('course_students.financial_status', '!=', $args['manager_financial_not_equal']);
                    }
                    return true;
                })
                ->where(function ($query) use ($args) {
                    if (isset($args['user_id_creator'])) {
                        $query->where('users.id', $args['user_id_creator']);
                    }
                    return true;
                })
                ->with('user_creator')
                ->where(function ($query) use ($args) {
                    if (isset($args['user_id_manager']))
                        $query->where('users.id', $args['user_id_manager']);
                    else
                        return true;
                })
                ->with('user_manager')
                ->where(function ($query) use ($args) {
                    if (isset($args['user_id_financial']))
                        $query->where('users.id', $args['user_id_financial']);
                    else
                        return true;
                })
                ->with('user_financial')
                ->where(function ($query) use ($args) {
                    if (isset($args['user_id_student_status']))
                        $query->where('users.id', $args['user_id_student_status']);
                    else
                        return true;
                })
                ->with('user_student_status');
            return $CourseStudent;
        }
        $CourseStudent = CourseStudent::where('deleted_at', null)
            ->where('id', -1);
        return  $CourseStudent;
    }
}
