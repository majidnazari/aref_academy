<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


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
        $user_id=auth()->guard('api')->user()->id;        
        $user_date=[
            'user_id_creator' => $user_id,
            'email' => $args['email'],
            'password' => $args['password'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
        ];
        $exist_user=User::where('email',$args['email'])->first();
        // if($exist_user){
        //     return Error::createLocatedError("USER-CREATE-RECORD_IS_EXIST");
        // }
        $user_resut=User::create($user_date);
        //return $user_resut;

        if($user_resut)
        {
            $group_user_data=[
                'user_id_creator' => 1,
                'user_id' => $user_resut->id,
                'group_id' => $args['group_id'],
                'key' =>''
                
            ];
          if( !$group_user_result= GroupUser::create($group_user_data))
          {
            return [
                'status'  => 'Error',
                'message' => __('cannot create group user'),
            ];
          }
          return $user_resut;
          
        }
        return [
            'status'  => 'Error',
            'message' => __('cannot create user'),
        ];
            
       
    }
}
