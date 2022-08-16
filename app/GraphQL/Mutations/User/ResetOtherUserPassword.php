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
use Log;
final class ResetOtherUserPassword
{
    private $group_role_access=array(
        "admin" => array( "manager","acceptor","teacher","financial"),        
        "manager" =>array ( "manager","acceptor","teacher"),
        "acceptor" => array("acceptor"),
        "teacher" =>array ("teacher"),
        "financial" =>array ("financial"),
        
    );
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
        $user_role_loged_in=auth()->guard('api')->user()->group->type;  
         
        $user=User::where('email',$args['email'])->first();       
        if(!$user)
        {
            return Error::createLocatedError('USER-UPDATE-PASSWORD-OTHER_NOT_FOUND');
        }
             
        if((auth()->guard('api')->user()->email===$args['email']) && (auth()->guard('api')->user()->group->type=="admin")) // change admin himself/herself password
        {
            return $this->registerNewPassword($user,$args['password'],$args['email']);
        }

        $user_tobe_changed_role=User::where('email',$args['email'])->first()->group->type;
        if($user_tobe_changed_role=="")        
        {
            return Error::createLocatedError('USER-UPDATE-PASSWORD-OTHER-ROLE_IS_NULL');
        }  

        return $this->hasAccessToRegister( $user_tobe_changed_role, $user_role_loged_in,$user,$args['password'],$args['email'] );
               
        //return Error::createLocatedError('USER-UPDATE-PASSWORD-OTHERـAUTHORIZATIONـFORBIDDEN');
    }
   public function hasAccessToRegister(string $user_tobe_changed_role,string $user_role_loged_in ,User $user,String $newPassword,String $email)
    {
        if(!in_array($user_tobe_changed_role,$this->group_role_access[$user_role_loged_in]))
        {
            return Error::createLocatedError('USER-UPDATE-PASSWORD-OTHERSـAUTHORIZATIONـFORBIDDEN');  
        }
        $result=$this->registerNewPassword($user,$newPassword,$email);
        return $result;
    }
    public function registerNewPassword(User $user,String $newPassword,String $email){

        $user=User::where('email',$email)->first();
        if(!$user){
            return Error::createLocatedError('USER-UPDATE-PASSWORD-OTHER_NOT_FOUND');
        }
        $user->password = Hash::make($newPassword);
        $user->save();
        //$result=User::updateOrCreate($user->toArray());        
        //Log::info("user is:" .$user );

        return $user;
    }

   
}
