<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsencePresence extends Model
{
    use HasFactory;
    use SoftDeletes;  
   
    protected $fillable=[
        "users_id",
        "course_sessions_id",
        "teachers_id",
        "status"        
    ];
    protected $table="absence_presences";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function CourseSession()
    // {
    //     return $this-blongsTo('CourseSession');
    // }
}
