<?php

namespace App\GraphQL\Mutations\StudentContact;

use App\Models\StudentContact;
use GraphQL\Error\Error;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

final class CreateStudentContact
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
        $student_contact_params = [
            'user_id_creator' => $user_id,
            "reason_absence" => isset($args['reason_absence']) ? $args['reason_absence'] : "",
            "absence_presence_id" => $args['absence_presence_id'],
            "who_answered" => isset($args['who_answered']) ? $args['who_answered'] : "",
            "description" => isset($args['description']) ? $args['description'] : "",
            "is_called_successfull" => isset($args['is_called_successfull']) ? $args['is_called_successfull'] : "",
        ];

        $is_exist_student_contact = StudentContact::where("absence_presence_id", $args['absence_presence_id'])->first();
        if ($is_exist_student_contact) {
            return Error::createLocatedError('STUDENT-CONTACT-RECORD_IS_EXIST');
        }
        $result = StudentContact::create($student_contact_params);
        return $result;
    }
}
