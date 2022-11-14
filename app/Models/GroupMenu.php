<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMenu  extends Pivot //extends Model
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use softDeletes;
    protected $fillable=
    [
        "user_id_creator",
        "menu_id",
        "group_id",
        "user_id"        
    ];
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
