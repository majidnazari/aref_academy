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
use GraphQL\Error\Error;


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
        $user_type=auth()->guard('api')->user()->group->type;  
            
        // $user_date=[
        //     //'user_id_creator' => $user_id,
        //     'group_id' => $args['group_id'],
        //     'branch_id' => $args['branch_id'],
        //     'email' => $args['email'],
        //     //'password' => $args['password'],
        //     'first_name' => $args['first_name'],
        //     'last_name' => $args['last_name'],
        // ];
        $exist_user=User::where('id',$args['id'])->first();
        //$exist_user=User::where('email',$args['email'])->first();
        if(!$exist_user){
            return Error::createLocatedError("USER-UPDATE-RECORD_IS_NOT_FOUND");
        }
        if(isset($args['group_id']))
        {
            if(in_array($args['group_id'],[1,3]) &&  $user_type=="manager") // manager add -> financial and admin user
            {
                return Error::createLocatedError("USER-UPDATE-MANAGER_ILLEGAL_ACCESS");            
            }
            if(in_array($args['group_id'],[2,4,5]) &&  $user_type=="manager") // manager add -> financial and admin user
            {            
              return  $this->updateUser( $exist_user,$args);           
            }
            // else
            // {
            //     return Error::createLocatedError("USER-UPDATE-MANAGER_ILLEGAL_ACCESS"); 
            // }
            if(in_array($args['group_id'],[1,2,3,4,5]) &&  $user_type=="admin") // admin  add -> All users 
            {
               
                return  $this->updateUser( $exist_user,$args);
               
            }
            return Error::createLocatedError("USER-UPDATE-REQUEST_IS_NOT_ACCEPTABLE"); //because group id is out of range
        }
       
        return  $this->updateUser( $exist_user,$args);
       
       
    }
    function updateUser($exist_user,$user_date)
    {  
        $user_id=auth()->guard('api')->user()->id;        
       // $exist_user["user_id_creator"]= $user_id;
        $result= $exist_user->fill($user_date); 
        $exist_user->save(); 
        return $result;// User::create($user);
        
    }
   
}
