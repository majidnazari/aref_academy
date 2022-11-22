<?php

namespace App\GraphQL\Queries\BranchClassRoom;

use App\Models\BranchClassRoom;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;

final class GetBranchClassRooms
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveBranchClassRoomsAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        if (AuthRole::CheckAccessibility("BranchClassRooms")) {
            //$BranchClassRoom= BranchClassRoom::where('deleted_at', null);
            $BranchClassRoom = BranchClassRoom::where('deleted_at', null)
                ->whereHas('branch', function ($query) use ($args,$branch_id) {
                    if (isset($args['branch_id'])) {
                        $query->where('branches.id', $args['branch_id']);
                    }
                    if($branch_id){

                        $query->where('id',$branch_id);

                    }
                    return true;
                })
                ->with('branch');
            return $BranchClassRoom;
        }
        $BranchClassRoom = BranchClassRoom::where('deleted_at', null)
            ->where('id', -1);
        return  $BranchClassRoom;
    }
}
