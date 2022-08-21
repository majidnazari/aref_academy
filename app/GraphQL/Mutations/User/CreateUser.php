<?php

namespace App\GraphQL\Mutations\User;

use App\Models\GroupGate;
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
        $user_type=auth()->guard('api')->user()->group->type;        
        $user_date=[
            'user_id_creator' => $user_id,
            'group_id' => $args['group_id'],
            'branch_id' => $args['branch_id'],
            'email' => $args['email'],
            'password' => $args['password'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
        ];
        $exist_user=User::where('email',$args['email'])->first();
        if($exist_user){
            return Error::createLocatedError("USER-CREATE-RECORD_IS_EXIST");
        }
        if(in_array($user_type,["acceptor","manager","teacher"])){
            // create just acceptor and manager and teacher
        }
        // if(//admin)
        //     {
        //         // create all 
        //     }
      
        //return $user_resut;
        $user_resut= User::create($user_date);

        if($user_resut)
        {
            $group_gate_data=[
                'user_id_creator' => $user_id,
                'user_id' => $user_resut->id,
                'group_id' => $args['group_id'],

                'key' =>''
                
            ];
          if( !$group_Gate_result= GroupGate::create($group_gate_data))
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
    // function createUser(User $user)
    // {
    //      return User::create($user_date);
        
    // }
}
