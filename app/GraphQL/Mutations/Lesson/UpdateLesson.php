<?php

namespace App\GraphQL\Mutations\Lesson;

use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateLesson
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
        $args["user_id_creator"]=$user_id;
        $Lesson=Lesson::find($args['id']);  
        if(!$Lesson)
        {
            return Error::createLocatedError('LESSON-UPDATE-RECORD_NOT_FOUND');
        }   
        $lesson_date=[           
             'name' => $args['name'],  
         ];
         $lesson=Lesson::where("name","=",$args['name'])->first();
         if($lesson)
         {
             return Error::createLocatedError('LESSON-UPDATE-RECORD_IS_EXIST');
         } 
        
        $year_filled= $Lesson->fill($args);
        $Lesson->save();       
       
        return $Lesson;

        
    }
}
