<?php

namespace App\GraphQL\Queries\Lesson;

use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;

final class GetLessons
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    
    function resolveLesson($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        if( AuthRole::CheckAccessibility("Lesson")){
            return Lesson::where('deleted_at', null);//->orderBy('id','desc');
        }
        $Lesson =Lesson::where('deleted_at',null)
        ->where('id',-1);       
        return  $Lesson;
       
    }
}
