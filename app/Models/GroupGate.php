<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupGate extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=
    [
        "user_id_created",
        "user_id",
        "group_id",
        "gate_id"        
    ];
}
