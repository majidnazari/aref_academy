<?php

namespace App\GraphQL\Queries\StudentWarning;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\StudentWarning;
use AuthRole;
use GraphQL\Error\Error;

final class GetStudentWarning
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentWarning($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $student_warning= StudentWarning::find($args['id']);
        return $student_warning;
    }
}
