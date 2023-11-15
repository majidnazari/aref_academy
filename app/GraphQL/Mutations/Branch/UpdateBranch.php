<?php

namespace App\GraphQL\Mutations\Branch;

use App\Models\Branch;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class UpdateBranch
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
        $args["user_id_creator"]=$user_id;
        $BranchResult=Branch::find($args['id']);
        
        if(!$BranchResult)
        {
            return Error::createLocatedError("BRANCH-UPDATE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی شعبه: رکورد مورد نظر یافت نشد.");
        }
        $BranchResult_filled= $BranchResult->fill($args);
        $BranchResult->save();       
       
        return $BranchResult;

        
    }
}
