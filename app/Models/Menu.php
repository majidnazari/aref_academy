<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use Log;

class Menu extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[       
        "slug",
        "name"  ,
        "icon",
        "href",
        "parent_id"

    ];
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    // public function parent()
    // {
    //     return $this->belongsTo(Menu::class,'parent_id');
    // }
    public function groupMenu()
    {
        return $this->hasMany(GroupMenu::class,"menu_id");
    }
    public function subMenus()
    {        
        // $groups=GroupMenu::where('menu_id',$this->id)->pluck("group_id");
        // Log::info("the id is:" . $this->id . "\n");
        // Log::info("groups:" . json_encode($groups));
        // $menus=GroupMenu::whereIn('group_id',$groups)->pluck('menu_id');
        // Log::info("menus:" . json_encode($menus));

        return $this->hasMany('App\Models\Menu', 'parent_id');
    }
}
