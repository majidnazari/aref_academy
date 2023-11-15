<?php

namespace App\GraphQL\Mutations\BranchClassRoom;

use App\Models\BranchClassRoom;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class UpdateBranchClassRoom
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
        $BranchClassRoomResult=BranchClassRoom::find($args['id']);
        
        if(!$BranchClassRoomResult)
        {
            return Error::createLocatedError("BRANCHCLASSROOM-UPDATE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی مراکز شعبه:رکورد مورد نظر یافت نشد.");
        }
        $BranchClassRoomResult_filled= $BranchClassRoomResult->fill($args);
        $BranchClassRoomResult->save();       
       
        return $BranchClassRoomResult;

        
    }
}
