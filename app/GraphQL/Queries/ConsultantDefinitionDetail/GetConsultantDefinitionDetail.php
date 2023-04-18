<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use AuthRole;
use Log;

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
        $ConsultantDefinitionDetail=ConsultantDefinitionDetail::where('id',$args['id']);
        
        if($branch_id)
        {
            return  $ConsultantDefinitionDetail->where('branch_id',$branch_id)->first();
        }
        
        return $ConsultantDefinitionDetail->first();
    }
    
}
