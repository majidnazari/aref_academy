<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use App\Models\BranchClassRoom;

final class GetConsultantDefinitionDetail
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantDefinitionDetailAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $branch_id = auth()->guard('api')->user()->branch_id;
        $branch_class_ids = BranchClassRoom::where('deleted_at', null)
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->pluck('id');

        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('id', $args['id'])
        // ->whereHas('branchClassRoom.branch', function ($query) use ($branches_id) {
            ->where(function ($query) use ($branch_class_ids) {
                if ($branch_class_ids) {
                    $query->whereIn('branch_class_room_id', $branch_class_ids);
                }
                //return $query->whereIn('id', $branches_id);
            })
            //->with('branchClassRoom.branch')
            ->first();

        return  $ConsultantDefinitionDetail;
    }
}
