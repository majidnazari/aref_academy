<?php

namespace App\GraphQL\Queries\Year;

use App\Models\Year;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;

final class GetYears
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    
    function resolveYear($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        if( AuthRole::CheckAccessibility("Year")){
             return Year::where('deleted_at', null);//->orderBy('id','desc');
        }
        $Year =Year::where('deleted_at',null)
        ->where('id',-1);       
        return  $Year;
    }
}
