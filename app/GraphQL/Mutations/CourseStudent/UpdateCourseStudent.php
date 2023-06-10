<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\CourseStudent;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateCourseStudent
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
        $args["user_id_creator"] = $user_id;
        $CourseStudente = CourseStudent::find($args['id']);

        if (!$CourseStudente) {
            return Error::createLocatedError("COURSESTUDENT-UPDATE-RECORD_NOT_FOUND");
        }

        if ((auth()->guard('api')->user()->group->type == "acceptor") && (in_array($args['student_status'], ["refused_pending", "fired_pending"]) == false)) {
            return Error::createLocatedError("COURSESTUDENT-UPDATE-ACTION_FORBIDEN");
        }
        if (isset($args['financial_status'])) {
            $CourseStudente['financial_status_updated_at'] = Carbon::now();
        }
        $CourseStudente_result = $CourseStudente->fill($args);
        if (isset($args['student_status'])) {

            $CourseStudente['user_id_student_status'] = $user_id;
        }
        if (isset($args['financial_status'])) {

            $CourseStudente['user_id_financial'] = $user_id;
        }
        if (isset($args['manager_status'])) {

            $CourseStudente['user_id_manager'] = $user_id;
        }

        $CourseStudente_result->save();

        return $CourseStudente_result;
    }
}
