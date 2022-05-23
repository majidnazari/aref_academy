<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

final class GetUsers
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    // function resolveUserAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    // {
    //     $users= User::paginate(2);       
    //     return $users;
    // }
    public function resolveUser($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
    //    $user= User::where('deleted_at', null);//->orderBy('id','desc');
    //    return $user;
        if(isset($args["group_id"]))
        {
            $user=User::where('deleted_at', null)->whereHas('groups',function ($query) use($args){
                $query->where("groups.id",$args["group_id"]);
            })        
            ->with('groups');
        }
            
            
            return $user;
    }

}
