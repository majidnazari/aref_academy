<?php

namespace App\GraphQL\Queries\BranchClassRoom;

use App\Models\BranchClassRoom;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

final class GetBranchClassRoom
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveBranchClassRoomAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;

        $BranchClassRoom = BranchClassRoom::where('id', $args['id'])
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
                return true;
            })
            ->first();

           // Log::info("report are:" . json_encode($branch_id ));

        return $BranchClassRoom;
    }
}
