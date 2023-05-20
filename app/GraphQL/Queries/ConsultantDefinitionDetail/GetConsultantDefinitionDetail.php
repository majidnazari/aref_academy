<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use AuthRole;
use Log;

final class GetConsultantDefinitionDetail
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantDefinitionDetailAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {

        $branch_id = auth()->guard('api')->user()->branch_id;
        $one_branch[]= $branch_id;        
        $all_branches=Branch::pluck('id');
        $all_branches[]=null;
        $branches_id=($branch_id===null) ? $all_branches :  $one_branch;       
        //Log::info(" the user branche is:". $branch_id ."all branches with nulluser are:" .  json_encode($branches_id));
        $ConsultantDefinitionDetail=ConsultantDefinitionDetail::where('id',$args['id'])
        ->whereHas('branchClassRoom.branch',function($query) use ($branches_id){
            return $query->whereIn('id',$branches_id);
        })        
        ->with('branchClassRoom.branch')
        ->first();

        return  $ConsultantDefinitionDetail;      
    }
    
}
