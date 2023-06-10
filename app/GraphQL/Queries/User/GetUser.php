<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use App\Models\Branch;

final class GetUser
{
    function resolveUserId($id): User
    {
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;
        $user = User::where('id', $id)->whereIn('branch_id', $branch_id);
        return $user;
    }

    function resolveUserAttribute($rootValue, array $args)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        $isNull = !isset($branch_id);


        $user = User::where('id', $args['id']);
        if (!$isNull) {
            $user = $user->where('branch_id', $branch_id);
        }
        return $user->first();
    }
}
