<?php

namespace App\GraphQL\Mutations\Fault;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Fault;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateFault
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
        $course_date=[
            'user_id_creator' => $user_id,
            "description" => $args['description'] 
        ];
        $course_result=Fault::create($course_date);
        return $course_result;
    }
}
