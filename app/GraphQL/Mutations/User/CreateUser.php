<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;


final class CreateUser
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
        $user_type = auth()->guard('api')->user()->group->type;

        $user_date = [
            'user_id_creator' => $user_id,
            'group_id' => $args['group_id'],
            'branch_id' => $args['branch_id'],
            'email' => $args['email'],
            'password' => $args['password'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
        ];
        return User::create($user_date);
    }
    function createUser($user)
    {
        return User::create($user);
    }
}
