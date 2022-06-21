<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

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
        //$CourseStudent= CourseStudent::where('deleted_at', null);//->orderBy('id','desc');
        $CourseStudent=CourseStudent::where('deleted_at', null)
                         ->whereHas('user_creator',function($query) use($args){
                                    if(isset($args['user_id_creator'])){
                                        $query->where('users.id',$args['user_id_creator']);
                                    }                                     
                                    return true;  

                          })
                          ->with('user_creator')
                          ->whereHas('user_manager',function($query) use($args){
                                    if(isset($args['user_id_manager']))
                                        $query->where('users.id',$args['user_id_manager']);
                                    else
                                        return true;
                          })
                          ->with('user_manager')
                          ->whereHas('user_financial',function($query) use($args){
                            if(isset($args['user_id_financial']))
                                $query->where('users.id',$args['user_id_financial']);
                            else
                                return true;
                            })
                            ->with('user_financial')
                            ->whereHas('user_student_status',function($query) use($args){
                                if(isset($args['user_id_student_status']))
                                    $query->where('users.id',$args['user_id_student_status']);
                                else
                                    return true;
                            })
                            ->with('user_student_status');
        return $CourseStudent;
    }
}
