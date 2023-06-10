<?php

namespace App\GraphQL\Mutations\Teacher;

use App\Models\Teacher;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateTeacher
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
        $user_id = auth()->guard('api')->user()->id;
        $teacher_date = [
            'user_id_creator' => $user_id,
            'mobile' => $args['mobile'],
            'address' => $args['address'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
        ];
        $teacher_resut = Teacher::create($teacher_date);
        return $teacher_resut;
    }
}
