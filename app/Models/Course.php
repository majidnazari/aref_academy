<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id",
        "teacher_id",
        "year_id",
        "name",
        "lesson",
        "type"
    ];
    public function User()
    {
        return $this->belongsTo('user');
    }
}
