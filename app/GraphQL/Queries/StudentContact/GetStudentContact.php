<?php

namespace App\GraphQL\Queries\StudentContact;

use App\Models\StudentContact;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetStudentContact
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentContactAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $StudentContact= StudentContact::find($args['id']);
        return $StudentContact;
    }
    function resolvetestAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {       
        return $args['token'];
    }
}
