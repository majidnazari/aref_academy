<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Azmoon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id",
        "course_id",
        "course_session_id",
        "isSMSsend",
        "score"        
    ];
    public function User()
    {
        return $this->belongsTo('user');
    }
    public function Course()
    {
        return $this->belongsTo('course');
    }
    public function CourseSession()
    {
        return $this->belongsTo('CourseSession');
    }
}
