<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[  
        "name"  
            ];
    
}
