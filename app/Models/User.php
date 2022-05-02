<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Concerns\BuildsQueries;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class User extends Authenticatable //implements JWTSubject //extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,BuildsQueries;

    //public function getAuthIdentifierName();
    //public function getAuthIdentifier();
    //public function getAuthPassword();
    // public function getRememberToken();
    // public function setRememberToken($value);
    // public function getRememberTokenName();

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "id",
        'type',
        //'mobile',
        'email',
        'password',
        'first_name',
        'last_name',
        'is_teacher'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        //'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    public function resolveUser($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        return DB::table('users')
        ->leftJoin('group_user','users.id','=','group_user.user_id')
        ->leftJoin('groups','group_user.user_id','=','groups.id');
           // ->leftJoinSub(...)
           // ->groupBy(...);
    }

    // public function gates()
    // {
    //     return $this->hasmany('Gate');
    // }
    // public function groups()
    // {
    //     return $this->belongsTo('Group');
    // }
    public function groups()
    {
       // return $this->belongsTo('Group');
        return $this->belongsToMany(Group::class)->withPivot(
            
            "id",
            "user_id_creator",
            "user_id",
            "group_id",
            "key",
            "created_at",
            "updated_at" 

        );//->using(GroupGate::class);
    }

    
    public function courses()
    {
        return $this->hasmany('Course');
    }
    public function courseSessions()
    {
        return $this->hasmany('CourseSession');
    }
    public function absencePresences()
    {
        return $this->hasmany('AbsencePresence');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }    
    
}
