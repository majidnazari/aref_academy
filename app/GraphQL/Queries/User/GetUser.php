<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetUser //implements ErrorHandler
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, Closure $next)
    {
        // TODO implement the resolver
        //return User::find($args['id']);
       // return null;      
       
    }
    function resolveUserId($id): User
    {        
        $user= User::find($id);
        return $user;
    }
    
    function resolveUserAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        // try
        // {
             $user= User::find($args['id']);
             return $user;
        // }
        // catch (\Throwable $error) {
        //     $errorPool = app(\Nuwave\Lighthouse\Execution\ErrorPool::class);
        //     $errorPool->record($error);
        // }
        
      
    }
}