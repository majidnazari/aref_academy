<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class ResetPassword
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
        $user_id_loged_in=auth()->guard('api')->user()->id;
        $user=User::where('email',$args['email'])->first();
        if($user_id_loged_in!=$user->id){
            return Error::createLocatedError('USER-AUTHORIZATION-FORBIDDEN');
        }
        //$user = $context->user();
        if( $user)
        {
            if (! Hash::check($args['old_password'], $user->password)) {
                throw new ValidationException([
                    'password' => __('Current password is incorrect'),
                ], 'Validation Exception');
            }
            $user->password = Hash::make($args['password']);
            $user->save();
            event(new PasswordUpdated($user));
    
            return [
                'status'  => 'PASSWORD_UPDATED',
                'message' => __('Your password has been updated'),
            ];
        }
        return [
            'status'  => 'ERROR FOR PASSWORD_UPDATED',
            'message' => __('User Doesn\'t Exist.'),
        ];
    }
   
}
