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

class User extends Authenticatable //implements JWTSubject //extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

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

    public function gates()
    {
        return $this->hasmany('Gate');
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
