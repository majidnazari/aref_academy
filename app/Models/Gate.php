<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class Gate extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[       
        "user_id",
        "name"  ,
        "description"
    ];
    public function user()
    {
        return $this->blongsTo(User::class,"user_id_creator");
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class,'group_gates','gate_id','group_id','id','id')->withPivot(["user_id_created"]);
    }
}
