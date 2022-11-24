<?php

namespace App\GraphQL\Mutations\Lesson;

use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use BasicModule;

final class CreateLesson
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
        $lesson_date=[
            'user_id_creator' => $user_id,
            'name' => $args['name'],
            //'active' => $args['active']
            
        ];
        $lesson= Lesson::where('name',$args['name'])->first();
        //$lesson=Lesson::where("name","=",$args['name'])->first();
        if($lesson)
        {
            return Error::createLocatedError('LESSON-CREATE-RECORD_IS_EXIST');
        }
        $lesson_resut= Lesson::create($lesson_date);
        //$lesson_resut=Lesson::create($lesson_date);
        return $lesson_resut;
    }

}
