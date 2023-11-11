<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Gate;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Group extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        "user_id_creator",
        "name",
        "type",
        "persian_name"
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class)->withTrashed();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->where('parent_id', 0)->withPivot(
            "id",
            "user_id_creator",
            "group_id",
            "menu_id",
            "created_at",
            "updated_at"

        );
    }
}
