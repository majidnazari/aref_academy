<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use App\Models\Branch;

final class GetUser
{
    function resolveUserId($id): User
    {
        $branch_id = auth()->guard('api')->user()->branch_id;

        $user = User::where('id', $id)
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->first();
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
