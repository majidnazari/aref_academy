<?php

namespace App\GraphQL\Mutations\Azmoon;

use App\Models\Azmoon;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateAzmoon
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
        $Azmoon=[
            'user_id_creator' => $user_id,
            "course_id" => $args['course_id'],
            "course_session_id" => $args['course_session_id'],            
            'isSMSsend' => $args['isSMSsend'],
            "score"=> $args["score"]           
            
        ];
        $Azmoon_result=Azmoon::create($Azmoon);
        return $Azmoon_result;
    }
}
