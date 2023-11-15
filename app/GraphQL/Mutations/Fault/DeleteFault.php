<?php

namespace App\GraphQL\Mutations\Fault;

use App\Models\Fault;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteFault
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
        $user_id = auth()->guard('api')->user()->id;        
        $Fault = Fault::find($args['id']);

        if (!$Fault) {
            return Error::createLocatedError("FAULT-DELETE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("حذف خطا: رکورد مورد نظر یافت نشد.");
        }
        $Fault_filled = $Fault->delete();
        return $Fault;
    }
}
