<?php

namespace App\GraphQL\Queries\StudentWarningHistory;

use GraphQL\Type\Definition\ResolveInfo;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use AuthRole;
use GraphQL\Error\Error;

final class GetStudentWarningHistory
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentWarningHistory($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $student_warning_historiy= StudentWarningHistory::find($args['id']);
        return $student_warning_historiy;
    }
}
