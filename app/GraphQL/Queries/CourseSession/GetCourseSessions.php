<?php

namespace App\GraphQL\Queries\CourseSession;

use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;

final class GetCourseSessions
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveCourseSession($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        if( AuthRole::CheckAccessibility("CourseSession")){
            return CourseSession::where('deleted_at', null)//;//->orderBy('id','desc');
            ->whereHas('course', function ($query) use ($branch_id) {
                if($branch_id!=""){
                    $query->where('branch_id', $branch_id);
                }  
                 return true;
            })->with('course');
       }
       $CourseSession =CourseSession::where('deleted_at',null)
       ->where('id',-1);       
       return  $CourseSession;
        
    }
}
