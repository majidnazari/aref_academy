<?php

namespace App\GraphQL\Queries\Branch;

use App\Models\Branch;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;

final class GetBranches
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    function resolveBranchesAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
       $branch_id = auth()->guard('api')->user()->branch_id;

       if( AuthRole::CheckAccessibility("Branches")){
            $Branch=( $branch_id != "" ) ? Branch::where('deleted_at', null)->where('id',$branch_id) : Branch::where('deleted_at', null);
            return $Branch;
       }
       $Branch =Branch::where('deleted_at',null)
       ->where('id',-1);       
       return  $Branch;
        
        
    }

}
