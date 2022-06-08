<?php

namespace App\GraphQL\Queries\StudentFault;

use App\Models\StudentFault;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetStudentFaults
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentFault($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $StudentFaults= StudentFault::where('deleted_at', null);//->orderBy('id','desc');
        return $StudentFaults;
    }
}
