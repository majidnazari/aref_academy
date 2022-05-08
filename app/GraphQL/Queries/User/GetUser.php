<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;


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
    
    function resolveUserAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)//: Builder
    {
       
        // return DB::table('users')
        // ->select('users.id As userId','users.*','group_user.*','groups.*','group_user.id As groupUserId','groups.id As groupId')
        // ->leftJoin('group_user','users.id','=','group_user.user_id')
        // ->leftJoin('groups','group_user.user_id','=','groups.id')
        // ->where('users.id',$args['id']);
            $user= User::find($args['id']);
            return $user;
        // }
        // catch (\Throwable $error) {
        //     $errorPool = app(\Nuwave\Lighthouse\Execution\ErrorPool::class);
        //     $errorPool->record($error);
        // }

        // return DB::table('users')
        // ->select('users.id As userId','users.*','group_user.*','groups.*','group_user.id As groupUserId','groups.id As groupId')
        // ->leftJoin('group_user','users.id','=','group_user.user_id')
        // ->leftJoin('groups','group_user.user_id','=','groups.id')
        // ->where('users.id',$args['id'])->get();
        
            
    }
}
