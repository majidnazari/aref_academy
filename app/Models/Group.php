<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Gate;

class Group extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[
        "user_id",
        "name"
    ];

    public function user()
    {
        return  $this->hasMany(User::class);
    }
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
    public function gates()
    {
        return $this->belongsToMany(Gate::class,'group_gates','group_id','gate_id','id','id')->withPivot(["user_id_created"]);
    }
}
