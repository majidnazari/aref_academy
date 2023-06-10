<?php

namespace App\GraphQL\Mutations\Azmoon;

use App\Models\Azmoon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteAzmoon
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
        $Azmoon=Azmoon::find($args['id']);
        
        if(!$Azmoon)
        {
           return Error::createLocatedError("BRANCH-DELETE-RECORD_NOT_FOUND");
        }
        $Azmoon_filled= $Azmoon->delete();
        $Azmoon->save();       
       
        return $Azmoon;

        
    }
}
