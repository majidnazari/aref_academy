<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Concerns\BuildsQueries;
use OwenIt\Auditing\Contracts\Auditable;


class User extends Authenticatable implements Auditable //implements JWTSubject //extends Authenticatable implements JWTSubject
{
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, BuildsQueries;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "id",
        'user_id_creator',
        'branch_id',
        'group_id',
        'email',
        'password',
        'first_name',
        'last_name'
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function years()
    {
        return $this->hasmany(Year::class);
    }

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
        return $this->belongsTo(Branch::class, "branch_id");
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
