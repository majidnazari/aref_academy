<?php

namespace App\GraphQL\Queries\User;

use App\AuthFacade\CheckAuthFacade;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Route;
use AuthRole;

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
        $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        //Log::info("the b are:" . json_encode($branch_ids));
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;      
        $user= User::where('id',$id)->whereIn('branch_id',$branch_id);
        return $user;
    }
    
    function resolveUserAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)//: Builder
    {
        $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');
        //Log::info("the b are:" . json_encode($branch_ids));
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;   
        // $allow_user=array("admin");
        // return auth()->guard('api')->user()->group->type;
        $user= User::where('id',$args['id'])->whereIn('branch_id',$branch_id)->first();
            return $user;
        // if(in_array($user_role,$allow_user))
        //     return true;
        // return false;
        // $g=User::where('deleted_at',null)
        // ->whereHas('groups', function($q) use($user_id) {
        //     $q->where('group_id','=',1)
        //     ->where('user_id',$user_id); 
        // }) 
        // ->first();
        // return $g->groups[0]->type;

      //$role= AuthRole::GetRole( $user_id);
        // $users_exist=User::where('deleted_at',null)
        // ->whereHas('groups', function($q) use($user_id) {
        //     $q->where('group_id',1)
        //     ->where('user_id',$user_id); 
        // }) 
        // ->with("groups")         
        // ->first();
        // return DB::table('users')
        // ->select('users.id As userId','users.*','group_user.*','groups.*','group_user.id As groupUserId','groups.id As groupId')
        // ->leftJoin('group_user','users.id','=','group_user.user_id')
        // ->leftJoin('groups','group_user.user_id','=','groups.id')
        // ->where('users.id',$args['id']);
        // if($users_exist){
        //     return "it is admin";
        // if($role=="admin"){
        //     $user= User::find($args['id']);
        //     return $user;
        // }
        // return null;
            
        // }
        // return "it is not admin";
           
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
