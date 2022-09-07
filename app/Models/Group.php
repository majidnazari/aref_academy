<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Gate;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Group extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[
        "user_id_creator",
        "name",
        "type",
        "persian_name"
    ];


    // public function resolveUser($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    // {
       
    //     return DB::table('groups')
    //     ->select('groups.id As groupId','groups.*');
    //     // ->leftJoin('group_user','users.id','=','group_user.user_id')
    //     // ->leftJoin('groups','group_user.user_id','=','groups.id');
    //        // ->leftJoinSub(...)
    //        // ->groupBy(...);
    // }
    public function users():HasMany
    {
        //return  $this->hasMany(User::class);
         return $this->hasMany(User::class);
         //->withPivot(

        //     "id",
        //     "user_id_creator",
        //     "user_id",
        //     "group_id",
        //     "key",
        //     "created_at",
        //     "updated_at"     

        // );
        //->withPivot(
            
        //     'user_id',
        //     'group_id',
        //     'key'

        // );;//->using(GroupGate::class);
    }
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class)->where('parent_id',0)->withPivot(
            "id",
            "user_id_creator",
            "group_id",
            "menu_id",
            "created_at",
            "updated_at"
            
        );
    }
    // public function gates()
    // {
    //     return $this->belongsToMany(Gate::class,'group_gates','group_id','gate_id','id','id')->withPivot(["user_id_created"]);
    // }
    // public function groupUser()
    // {
    //     return $this->belongsToMany(GroupUser::class,'group_user','group_id','user_id','id','id')->withPivot(["user_id_created","key"]);
    // }
}
