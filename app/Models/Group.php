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
        "name",
        "type"
    ];

    public function users()
    {
        //return  $this->hasMany(User::class);
         return $this->belongsToMany(User::class);
         //->withPivot(

        //     "id",
        //     "user_id_creator",
        //     "user_id",
        //     "group_id",
        //     "key",
        //     "created_at",
        //     "updated_at"     

        // );
        //->withPivot(
            
        //     'user_id',
        //     'group_id',
        //     'key'

        // );;//->using(GroupGate::class);
    }
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withPivot(
            "id",
            "user_id_creator",
            "group_id",
            "menu_id",
            "created_at",
            "updated_at"
        );
    }
    public function gates()
    {
        return $this->belongsToMany(Gate::class,'group_gates','group_id','gate_id','id','id')->withPivot(["user_id_created"]);
    }
}
