<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\BranchClassRoom;
use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Carbon\Carbon;
use AuthRole;
use GraphQL\Error\Error;
use Log;

final class GetAbsentStudentSession
{
    function resolveGetAbsentStudentSession($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {


        if (!AuthRole::CheckAccessibility("ConsultantDefinitionDetail")) {
            return [];
        }
        $starSession =  Carbon::now()->subDays(14)->format("Y-m-d");
        $endSession =  Carbon::now()->format("Y-m-d");

        // Log::info("resolveConsultantDefinitionDetails" . $starSession  );
        // $startOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        // $endOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

        // $tempDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_from']) : Carbon::parse($startOfWeek);
        // $finishDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_to']) : Carbon::parse($endOfWeek);

        if (!isset($args['student_id'])) {
            throw new Error('CONSULTANTDEFINITIONDETAIL-GET-RECORD_STUDENT_NOT_FOUND.');
            //return Error::createLocatedError('CONSULTANTDEFINITIONDETAIL-GET-RECORD_STUDENT_NOT_FOUND');
        }

        $branch_id = auth()->guard('api')->user()->branch_id;
        $branch_class_ids = BranchClassRoom::where('deleted_at', null)
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->pluck('id');
        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('deleted_at', null)
            ->where('student_id', $args['student_id'])
            ->where(function ($query) use ($args, $branch_id, $branch_class_ids, $starSession, $endSession) {
                if (isset($args['consultant_id']))
                    $query->where('consultant_id', $args['consultant_id']);
                if ($branch_class_ids) {
                    $query->whereIn('branch_class_room_id', $branch_class_ids);
                }

                $query->where('session_date', '>=', $starSession);
                $query->where('session_date', '<=', $endSession);
                if (isset($args['consultant_test_id'])) $query->where('consultant_test_id', $args['consultant_test_id']);
                if (isset($args['user_id'])) $query->where('user_id', $args['user_id']);
                if (isset($args['start_hour_from'])) $query->where('start_hour', '>=', $args['start_hour_from']);
                if (isset($args['start_hour_to'])) $query->where('start_hour', '<=', $args['start_hour_to']);
                if (isset($args['end_hour_from'])) $query->where('end_hour', '>=', $args['end_hour_from']);
                if (isset($args['end_hour_to'])) $query->where('end_hour', '<=', $args['end_hour_to']);
                if (isset($args['student_status'])) $query->whereIn('student_status', $args['student_status']);
                if (isset($args['consultant_status'])) $query->where('consultant_status', $args['consultant_status']);
                if (isset($args['student_id'])) $query->where('student_id', $args['student_id']);
                if (isset($args['absent_present_description'])) $query->where('absent_present_description', $args['absent_present_description']);
                if (isset($args['test_description'])) $query->where('test_description', $args['test_description']);
                if (isset($args['step'])) $query->where('step', $args['step']);
                if (isset($args['compensatory_for_definition_detail_id']) && ($args['compensatory_for_definition_detail_id'] == -2)) {
                    $query->where('compensatory_for_definition_detail_id', null);
                }
            })
            ->with(['user', 'consultant', 'branchClassRoom'])
            ->orderBy('session_date', 'asc');
        // ->get();

        return $ConsultantDefinitionDetail;



        // $data = [];
        // $index = 0;

        //Log::info("fth:".Carbon::parse($tempDate))->copy()->format("Y-m-d");

        // while (($tempDate <= $finishDate) && ($index <= 6)) {
        //     $data[] = [
        //         "date" => Carbon::parse($tempDate)->copy()->format("Y-m-d"),
        //         "details" => $this->getDateData($ConsultantDefinitionDetail, $tempDate)
        //     ];
        //     $tempDate = $tempDate->addDays(1);
        //     $index++;
        // }
        // return $data;

    }    
}
