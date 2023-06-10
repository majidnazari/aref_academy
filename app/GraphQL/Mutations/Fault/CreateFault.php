<?php

namespace App\GraphQL\Mutations\Fault;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Fault;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateFault
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
        $fault_date = [
            'user_id_creator' => $user_id,
            "description" => $args['description']
        ];
        $is_exist = Fault::where($fault_date)
            ->first();
        if ($is_exist) {
            return Error::createLocatedError("FAULT-CREATE-RECORD_IS_EXIST");
        }
        $fault_result = Fault::create($fault_date);
        return $fault_result;
    }
}
