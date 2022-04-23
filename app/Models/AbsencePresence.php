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
        "id",
        "user_id",
        "course_session_id",
        "teacher_id",
        "status"        
    ];
    protected $table="absence_presences";

    public function user()
    {
        //return $this->belongsTo("users","id","user_id");
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'email','first_name', 'last_name');
    }
    public function courseSession()
    {
        return $this->hasOne('App\Models\CourseSession',"id","course_session_id");
    }
    public function teacher()
    {
        return $this->hasOne('App\Models\teacher',"id","teacher_id");
    }
}
