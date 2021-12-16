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
        "user_id",
        "course_id",
        "name",
        "start_date",
        "start_time",
        "end_time",
        
    ];
    public function User()
    {
        return $this->blongsTo('user');
    }
    public function course()
    {
        return $this->hasmany('course');
    }    
}
