<?php

namespace App\GraphQL\Mutations\StudentContact;

use App\Models\StudentContact;
use GraphQL\Error\Error;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

final class DeleteStudentContact
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
        $StudentContact = StudentContact::find($args['id']);

        if (!$StudentContact) {
            return Error::createLocatedError("STUDENTCONTACT-DELETE-RECORD_NOT_FOUND");
        }
        $StudentContact_result = $StudentContact->delete();

        return $StudentContact;
    }
}
