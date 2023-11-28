<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\BranchClassRoom;
use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Log;

final class CopyStudentToNextTimeTable
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function copyOneStudentToNextTimeTable($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $definition_id = $args['id'];


        $definition_this_week = ConsultantDefinitionDetail::where('id',  $definition_id)->first();

        $now=Carbon::now()->format("Y-m-d");
         //Log::info("now is:"  . $now . " and session_date is:" .$consultantDefinition['session_date'] );        

        if($definition_this_week['session_date'] < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");

        }

        if (empty($definition_this_week['student_id'])) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_STUDENT_NOT_FOUND");
            //return Error::createLocatedError("کپی دانش آموز:دانش آموز مورد نظر یافت نشد.");
        }

        $student_id = $definition_this_week['student_id'];
        $next_session = Carbon::parse($definition_this_week['session_date'])->addDays(7)->format("Y-m-d");
        $start_hour = $definition_this_week["start_hour"];
        $end_hour = $definition_this_week["end_hour"];
        $consultant_id = $definition_this_week["consultant_id"];
        $branch_class_room_id = $definition_this_week["branch_class_room_id"];

        $definition_next_week = ConsultantDefinitionDetail::where("session_date", $next_session)
            ->where("start_hour", $start_hour)
            ->where("end_hour", $end_hour)
            ->where("consultant_id", $consultant_id)
            ->where("branch_class_room_id", $branch_class_room_id)
            ->first();

        //Log::info("next is:" .  json_encode($definition_next_week));

        if (empty($definition_next_week)) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_NEXT_TIME_NOT_FOUND");
            //return Error::createLocatedError("کپی دانش آموز: زمانبندی هفته بعد برای این دانش آموز وجود ندارد.");
        }

        if (!empty($definition_next_week["student_id"])) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_NEXT_TIME_HAS_STUDENT");
            //return Error::createLocatedError("کپی دانش آموز:تایم هفته آینده پر است.");
        }

        $definition_next_week["student_id"] = $student_id;

        $definition_next_week->update();
        return $definition_next_week;
    }
}
