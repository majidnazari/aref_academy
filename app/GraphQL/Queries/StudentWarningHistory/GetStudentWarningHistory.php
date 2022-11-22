<?php

namespace App\GraphQL\Queries\StudentWarningHistory;

use GraphQL\Type\Definition\ResolveInfo;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use AuthRole;
use GraphQL\Error\Error;

final class GetStudentWarningHistory
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentWarningHistory($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        // $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        // $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        // //Log::info("the b are:" . json_encode($branch_id));
        // $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;   
        
        $branch_id = auth()->guard('api')->user()->branch_id;
        
        $student_warning_historiy= StudentWarningHistory::where('id',$args['id'])
        ->whereHas('course', function ($query) use ($branch_id) {
            if($branch_id){
                $query->where('branch_id', $branch_id);
            }  
            return true;
        })->with('course')->first();
        return $student_warning_historiy;
    }
}
