<?php

namespace App\GraphQL\Mutations\Branch;

use App\Models\Branch;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteBranch
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {  
        $user_id=auth()->guard('api')->user()->id;        
        $BranchResult=Branch::find($args['id']);
        
        if(!$BranchResult)
        {
            return Error::createLocatedError("BRANCH-CREATE-RECORD_IS_EXIST");
        }
        $BranchResult_filled= $BranchResult->delete();  
        return $BranchResult;

        
    }
}
