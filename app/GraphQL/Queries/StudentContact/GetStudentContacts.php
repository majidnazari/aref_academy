<?php

namespace App\GraphQL\Queries\StudentContact;

use App\Models\StudentContact;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetStudentContacts
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentContact($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $StudentContact= StudentContact::where('deleted_at', null);//->orderBy('id','desc');
        return $StudentContact;
    }
}
