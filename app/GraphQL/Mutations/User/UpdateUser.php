<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupGate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class UpdateUser
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
        $args["user_id_creator"] = $user_id;
        $user = User::find($args['id']);
        if (!$user) {
            return [
                'status'  => 'Error',
                'message' => __('cannot update gate'),
            ];
        }
        // if(isset($args['email']))
        // {
        //     $user->email=$args['email'];
        // }
        // if(isset($args['first_name']))
        // {
        //     $user->first_name=$args['first_name'];
        // }
        // if(isset($args['last_name']))
        // {
        //     $user->last_name=$args['last_name'];
        // }
        // if(isset($args['last_name']))
        // {
        //     $user->last_name=$args['last_name'];
        // }
        $user->fill($args);
        $user->save();

        if (isset($args['group_id'])) {
            $groupUser = GroupGate::where('user_id', $user->id)->first();
            if (!$groupUser) {
                throw new ValidationException([
                    'group_gate' => __('caanot find user group with this id.'),
                ], 'New Exception');
            }
            $groupUser->group_id = $args['group_id'];
            $groupUser->save();
        }
        return $user;
    }
}
