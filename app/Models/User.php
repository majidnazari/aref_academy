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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use OwenIt\Auditing\Contracts\Auditable;


class User extends Authenticatable implements Auditable //implements JWTSubject //extends Authenticatable implements JWTSubject
{
    use \OwenIt\Auditing\Auditable;
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
        'user_id_creator',
        //'mobile',
        'branch_id',
        'group_id',
        'email',
        'password',
        'first_name',
        'last_name'
        //'is_teacher'
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

    
    // public function gates()
    // {
    //     return $this->hasmany('Gate');
    // }
    // public function groups()
    // {
    //     return $this->belongsTo('Group');
    // }
    public function group()
    {
        return $this->belongsTo(Group::class);
        // return $this->belongsToMany(Group::class)->withPivot(
        //     "id",
        //     "user_id_creator",
        //     "key",
        //     "user_id",
        //     "group_id"

        // );
        // ->using(GroupUser::class) // only needed to retrieve the tag from the tag_id
        // ->withPivot('created_at');
       // return $this->belongsTo('Group');
        // return $this->belongsToMany(Group::class)->withPivot(
            
        //     "id",
        //     "groupId",
        //     "user_id_creator",
        //     "user_id",
        //     "group_id",
        //     "key",
        //     "created_at",
        //     "updated_at" 

        // )->using(GroupUser::class);
    }
    public function years() 
    {
        return $this->hasmany(Year::class);
    }
    // public function fault():HasMany
    // {
    //     return $this->hasMany(Fault::class,"user_id_creator");
    // }
    public function faults()
    {
        return $this->hasMany(Fault::class);
    }
    
    public function courses()
    {
        return $this->hasmany('Course');
    }
   
    public function branch()
    {
        return $this->belongsTo(Branch::class,"branch_id");
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
