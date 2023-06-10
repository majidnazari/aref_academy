<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;;

class Menu extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        "slug",
        "name",
        "icon",
        "href",
        "parent_id"

    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function groupMenu()
    {
        return $this->hasMany(GroupMenu::class, "menu_id");
    }
    public function subMenus()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id');
    }
}
