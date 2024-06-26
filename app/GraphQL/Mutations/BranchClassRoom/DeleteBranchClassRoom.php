<?php

namespace App\GraphQL\Mutations\BranchClassRoom;

use App\Models\BranchClassRoom;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class DeleteBranchClassRoom
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
        //$args["user_id_creator"]=$user_id;
        $BranchClassRoomResult=BranchClassRoom::find($args['id']);

        // if ($BranchClassRoomResult->references()->exists()) {
        //     return Error::createLocatedError('BRANCHCLASSROOM-DELETE-IT_IS_USED_IN_OTHER_MODELS.');
        // }
        
        if(!$BranchClassRoomResult)
        {
            return Error::createLocatedError("BRANCHCLASSROOM-DELETE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("حذف کلا سهای شعبه:رکورد مورد نظر یافت نشد. ");
        }

        // check if it is used
        // Log::info("c: " . json_encode($BranchClassRoomResult->consultantDefinitionDetails));
        if ($BranchClassRoomResult->consultantDefinitionDetails && count($BranchClassRoomResult->consultantDefinitionDetails)) {
            return Error::createLocatedError("BRANCHCLASSROOM-DELETE-RECORD_USED_IN_CONSULTANT_DEFINITION_DETAIL");
        }

        $BranchClassRoomResult->delete();              
       
        return $BranchClassRoomResult;

        
    }
}
