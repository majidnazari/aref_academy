<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Contracts\Auth\Authenticatable;

class User extends Authenticatable implements JWTSubject //extends Authenticatable implements JWTSubject
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
        'mobile',
        'first_name',
        'last_name',
        'email',
        'password',
        'type'
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

    public function Gates()
    {
        return $this->hasmany('Gates');
    }
    public function Courses()
    {
        return $this->hasmany('Courses');
    }
    public function CourseSessions()
    {
        return $this->hasmany('CourseSessions');
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
