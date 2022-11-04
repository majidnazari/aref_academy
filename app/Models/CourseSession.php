<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CourseSession extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $table='course_sessions';
    protected $fillable=[
        
        "user_id_creator",
        "branch_class_room_id",
        "course_id",
        "name",
        "price",
        "special",
        "start_date",
        "start_time",
        "end_time",
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }    
    public function classRoom()
    {
        return $this->belongsTo(BranchClassRoom::class,"branch_class_room_id");
    }   
    public function absencePresences() 
    {
        return $this->hasMany(AbsencePresence::class,"course_session_id");
    }
     
}
