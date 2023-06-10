<?php

namespace App\GraphQL\Mutations\AbsencePresence;

use App\Models\AbsencePresence;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteAbsencePresence
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
        $AbsencePresence=AbsencePresence::find($args['id']);
        
        if(!$AbsencePresence)
        {
            return Error::createLocatedError('ABSENCEPRESENCE-DELETE-RECORD_NOT_FOUND');
        }
        $AbsencePresence_result= $AbsencePresence->delete();           
       
        return $AbsencePresence;

        
    }
}
