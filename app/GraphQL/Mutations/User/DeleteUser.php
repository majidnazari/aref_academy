<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class DeleteUser
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

    }
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $user = User::find($args['id']);
        if ($user_id == $args['id']) {
            return Error::createLocatedError("USER-DELETE-CANNOT_SUICIDE");
        }
        if (!$user) {
            return Error::createLocatedError("USER-DELETE-RECORD_NOT_FOUND");
        }
        $user_filled = $user->delete();
        return $user;
    }
}
