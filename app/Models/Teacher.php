<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=
    [
        "id",
        "first_name",
        "last_name",
        "mobile",
        "address",
        "user_id_creator"
       
    ];
    public function user()
    {
        return $this->belongsTo('user');
    }
}
