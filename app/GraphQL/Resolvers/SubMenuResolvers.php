<?php

namespace App\GraphQL\Resolvers;

use App\Models\Group;
use App\Models\GroupMenu;
use App\Models\Menu;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use Log;

class SubMenuResolvers
{
    /**
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  array<string, mixed>  $whereConditions
     */
    public function subMenuResolver($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $group_menue_ids = GroupMenu::where('group_id', $rootValue['pivot']['group_id'])->pluck("menu_id");

        return Menu::where("parent_id", $rootValue['id'])->whereIn('id', $group_menue_ids)->get();
    }
}
