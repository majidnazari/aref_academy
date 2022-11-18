<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AbsencePresence extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;  
   
    protected $fillable=[
        "id",
        "user_id_creator",
        "student_id",
        "course_session_id",
        "teacher_id",
        "status"  ,
        "attendance_status"      
    ];
    protected $table="absence_presences"; 

    public function user()
    {
        //return $this->belongsTo("users","id","user_id");
        //return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'email','first_name', 'last_name');
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function courseSession()
    {
        return $this->belongsTo(CourseSession::class,"course_session_id");
        //return $this->belongsTo(CourseSession::class,"course_session_id");
    }
    public function teacher()
    {
        return $this->belongsTo(User::class,"teacher_id");
    }
}
