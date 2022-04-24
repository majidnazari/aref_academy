<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class GetUser
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $user = User::where('id', $args['id'])->first();
        return $user;
    }
}
