<?php

namespace App\GraphQL\Mutations;
use App\Models\User as ModelsUser;

class UpdateUser
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $user=ModelsUser::find($args['id']);
        $user->update([
        "first_name" => $args['first_name'],
        "last_name" => $args['last_name'],
                    ]);

                    return $user;
    }
}
