<?php

namespace App\GraphQL\Queries\Course;

use App\Models\Course;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use Log;

final class GetCourse
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        // $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        // $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        //Log::info("the b are:" . json_encode($args));
        // $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;
        $branch_id = auth()->guard('api')->user()->branch_id; 
        $course=Course::where('id',$args['id']);
        
        if($branch_id)
        {
            return  $course->where('branch_id',$branch_id)->first();
        }
        
        return $course->first();
    }
}
