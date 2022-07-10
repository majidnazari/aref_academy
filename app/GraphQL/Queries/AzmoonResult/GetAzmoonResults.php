<?php

namespace App\GraphQL\Queries\AzmoonResult;

use App\Models\AzmoonResult;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use AuthRole;
use GraphQL\Error\Error;

final class GetAzmoonResults
{
    public function resolveAzmoonResult($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {  
       if( AuthRole::CheckAccessibility()){
            return AzmoonResult::where('deleted_at', null);
       }
       $AzmoonResult =AzmoonResult::where('deleted_at',null)
       ->where('id',-1);       
       return  $AzmoonResult;
    }
}
