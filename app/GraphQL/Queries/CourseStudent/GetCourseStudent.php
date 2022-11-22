<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use Log;

final class GetCourseStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudentAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        // $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        // $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        // //Log::info("the b are:" . json_encode($branch_ids));
        // $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;

        $branch_id = auth()->guard('api')->user()->branch_id;
        //Log::info("the b is:" . $branch_id);
        $CourseStudent= CourseStudent::where('id',$args['id'])
        ->whereHas('course', function ($query) use ($branch_id) {
            if($branch_id){
                $query->where('branch_id', $branch_id);
            }  
             return true;
        })->with('course');
        return $CourseStudent;
    }
}
