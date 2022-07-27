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

final class ResetOtherUserPassword
{
    private $group_role_access=array(
        "admin" => array( "admin","manager","acceptor","teacher","financial"),
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
        //return $this->group_role_access[$user_role_loged_in] ;
        $user=User::where('email',$args['email'])->first();
        //$user = $context->user();
        if(!$user)
        {
            return Error::createLocatedError('USER-NOT-FOUND');
        }
        $user_tobe_changed_role=User::where('email',$args['email'])->first()->group->type;
        if($user_tobe_changed_role=="")        
        {
            return Error::createLocatedError('USER-ROLE_NOT-FOUND');
        }
       // return in_array($user_tobe_changed_role,$this->group_role_access[$user_role_loged_in]);
        if( in_array($user_tobe_changed_role,$this->group_role_access[$user_role_loged_in]) )
        {
           
            $user->password = Hash::make($args['password']);
            $user->save();
            $user=User::where('email',$args['email'])->first();
            return $user;
        }
        
        return Error::createLocatedError('USER-AUTHORIZATION-FORBIDDEN');
    }
   
}
