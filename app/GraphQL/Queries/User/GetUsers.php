<?php

namespace App\GraphQL\Queries\User;

use App\Models\Branch;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use AuthRole;

final class GetUsers
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    private $group_access_Not_showing_all_branches = array("admin");
    public function resolveUser($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user_role = auth()->guard('api')->user()->group->type;
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("Users")) {
            $user = User::where('deleted_at', null);
            if (!($isNotAmin = in_array($user_role, $this->group_access_Not_showing_all_branches))) //it means if it is not admin branch where executes.
            {
                $user->whereIn('branch_id', $branch_id);
            }
            $user->whereHas('group', function ($query) use ($args) {
                if (isset($args["group_id"]))
                    $query->where("groups.id", $args["group_id"]);
                else
                    return true;
            })
                ->with('group');
            return $user;
        }
        $User = User::where('deleted_at', null)
            ->where('id', -1);
        return  $User;
    }
}
