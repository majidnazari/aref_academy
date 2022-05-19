<?php

namespace App\GraphQL\Queries\AbsencePresence;

use App\Models\AbsencePresence;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetAbsencePresences
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveAbsencePresence($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $AbsencePresence= AbsencePresence::where('deleted_at', null);//->orderBy('id','desc');
        return $AbsencePresence;
    }
}
