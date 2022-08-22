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
        return User::create($user_date);
        // $exist_user=User::where('email',$args['email'])->first();
        // if($exist_user){
        //     return Error::createLocatedError("USER-CREATE-RECORD_IS_EXIST");
        // }
        // if(in_array($args['group_id'],[1,3]) &&  $user_type=="manager") // manager add -> financial and admin user
        // {
        //     return Error::createLocatedError("USER-CREATE-MANAGER_ILLEGAL_ACCESS"); 
        // }
        // if(in_array($args['group_id'],[2,4,5]) &&  $user_type=="manager") // manager add -> financial and admin user
        // {
            
        //     return  $this->createUser($user_date);
           
        // }
        // // else
        // // {
        // //     return Error::createLocatedError("USER-CREATE-MANAGER_ILLEGAL_ACCESS"); 
        // // }
        // if(in_array($args['group_id'],[1,2,3,4,5]) &&  $user_type=="admin") // admin  add -> All users 
        // {
           
        //     return  $this->createUser($user_date);
           
        // }
        // return Error::createLocatedError("USER-CREATE-REQUEST_IS_NOT_ACCEPTABLE"); //because group id is out of range
       
       
    }
    function createUser($user)
    {       
         return User::create($user);
        
    }
}
