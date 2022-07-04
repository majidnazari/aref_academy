<?php

namespace App\GraphQL\Mutations\Teacher;

use App\Models\Teacher;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class UpdateTeacher
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
        $teacher=Teacher::find($args['id']);
        
        if(!$teacher)
        {
            return [
                'status'  => 'Error',
                'message' => __('cannot update teacher'),
            ];
        }
        $teacher_filled= $teacher->fill($args);
        $teacher->save();       
       
        return $teacher;

        
    }
   
}
