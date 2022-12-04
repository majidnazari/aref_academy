<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CourseStudent extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[        
        "course_id",
        "course_session_id",
        "student_id",        
        "manager_status",
        "financial_status",
        "student_status",        
        "user_id_creator",
        "user_id_manager",
        "user_id_financial",
        "user_id_student_status",
        "description",
        "total_not_registered",
        "total_noAction",
        "total_dellay60",
        "total_dellay45",
        "total_dellay30",
        "total_dellay15",
        "total_present",
        "total_absent",
        "sum_total_present",        
        "financial_refused_status",
        "transferred_to_course_id",
        "financial_status_updated_at",
    ];
    public function user_creator()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function user_manager()
    {
        return $this->belongsTo(User::class,"user_id_manager");
    }
    public function user_financial()
    {
        return $this->belongsTo(User::class,"user_id_financial");
    }
    public function user_student_status()
    {
        return $this->belongsTo(User::class,"user_id_student_status");
    }
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    } 
    public function transferred_course()
    {
        return $this->belongsTo(Course::class,"transferred_to_course_id");
    }  
      
    
}
