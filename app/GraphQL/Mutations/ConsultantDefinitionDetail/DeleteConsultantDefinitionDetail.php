<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class DeleteConsultantDefinitionDetail
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {  
        $user_id=auth()->guard('api')->user()->id;  
        $ConsultantDefinitionDetailResultIds=ConsultantDefinitionDetail::whereIn('id',$args['id'])->get();  
        $ConsultantDefinitionDetail_deleted= ConsultantDefinitionDetail::whereIn('id',$args['id'])->delete();  
        if(!$ConsultantDefinitionDetail_deleted)
        {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CANNOT-DELETE_RECORDS");
        }        
        return $ConsultantDefinitionDetailResultIds;        
    }
}
