<?php

namespace App\GraphQL\Queries\User;

use App\Models\Branch;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use AuthRole;
use Log;

final class GetConsultants
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
    public function resolveConsultant($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {        
        $branch_id = auth()->guard('api')->user()->branch_id;        
        if (AuthRole::CheckAccessibility("Consultants")) {
           
            $consultant = User::where('deleted_at', null);           
            if($branch_id)
            {
                $consultant->where('branch_id', $branch_id);
            }
            $consultant->where('group_id',6)
            ->get();
            return $consultant;
        }
        $consultant = User::where('deleted_at', null)
            ->where('id', -1);
        return  $consultant;
    }
}
