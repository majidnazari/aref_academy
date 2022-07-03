<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSession extends Model
{
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
}
