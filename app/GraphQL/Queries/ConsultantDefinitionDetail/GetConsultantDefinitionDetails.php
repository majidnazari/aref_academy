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

final class GetConsultantDefinitionDetails
{
    // function resolveConsultantDefinitionDetails($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    // {


    //     if (!AuthRole::CheckAccessibility("ConsultantDefinitionDetail")) {
    //         return [];
    //     }
    //     $starSession =  Carbon::now()->subDays(14)->format("Y-m-d");
    //     $endSession =  Carbon::now()->format("Y-m-d");

    //     // Log::info("resolveConsultantDefinitionDetails" . $starSession  );
    //     // $startOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
    //     // $endOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

    //     // $tempDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_from']) : Carbon::parse($startOfWeek);
    //     // $finishDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_to']) : Carbon::parse($endOfWeek);

    //     if (!isset($args['student_id'])) {
    //         return Error::createLocatedError('CONSULTANTDEFINITIONDETAIL-GET-RECORD_STUDENT_NOT_FOUND');
    //     }

    //     $branch_id = auth()->guard('api')->user()->branch_id;
    //     $branch_class_ids = BranchClassRoom::where('deleted_at', null)
    //         ->where(function ($query) use ($branch_id) {
    //             if ($branch_id) {
    //                 $query->where('branch_id', $branch_id);
    //             }
    //         })
    //         ->pluck('id');
    //     $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('deleted_at', null)
    //         ->where('student_id', $args['student_id'])
    //         ->where(function ($query) use ($args, $branch_id, $branch_class_ids, $starSession, $endSession) {
    //             if (isset($args['consultant_id']))
    //                 $query->where('consultant_id', $args['consultant_id']);
    //             if ($branch_class_ids) {
    //                 $query->whereIn('branch_class_room_id', $branch_class_ids);
    //             }

    //             $query->where('session_date', '>=', $starSession);
    //             $query->where('session_date', '<=', $endSession);
    //             if (isset($args['consultant_test_id'])) $query->where('consultant_test_id', $args['consultant_test_id']);
    //             if (isset($args['user_id'])) $query->where('user_id', $args['user_id']);
    //             if (isset($args['start_hour_from'])) $query->where('start_hour', '>=', $args['start_hour_from']);
    //             if (isset($args['start_hour_to'])) $query->where('start_hour', '<=', $args['start_hour_to']);
    //             if (isset($args['end_hour_from'])) $query->where('end_hour', '>=', $args['end_hour_from']);
    //             if (isset($args['end_hour_to'])) $query->where('end_hour', '<=', $args['end_hour_to']);
    //             if (isset($args['student_status'])) $query->whereIn('student_status', $args['student_status']);
    //             if (isset($args['consultant_status'])) $query->where('consultant_status', $args['consultant_status']);
    //             if (isset($args['student_id'])) $query->where('student_id', $args['student_id']);
    //             if (isset($args['absent_present_description'])) $query->where('absent_present_description', $args['absent_present_description']);
    //             if (isset($args['test_description'])) $query->where('test_description', $args['test_description']);
    //             if (isset($args['step'])) $query->where('step', $args['step']);
    //             if (isset($args['compensatory_for_definition_detail_id']) && ($args['compensatory_for_definition_detail_id'] == -2)) {
    //                 $query->where('compensatory_for_definition_detail_id', null);
    //             }
    //         })
    //         ->with(['user', 'consultant', 'branchClassRoom'])
    //         ->orderBy('session_date', 'asc');
    //     // ->get();

    //     return $ConsultantDefinitionDetail;



    //     // $data = [];
    //     // $index = 0;

    //     //Log::info("fth:".Carbon::parse($tempDate))->copy()->format("Y-m-d");

    //     // while (($tempDate <= $finishDate) && ($index <= 6)) {
    //     //     $data[] = [
    //     //         "date" => Carbon::parse($tempDate)->copy()->format("Y-m-d"),
    //     //         "details" => $this->getDateData($ConsultantDefinitionDetail, $tempDate)
    //     //     ];
    //     //     $tempDate = $tempDate->addDays(1);
    //     //     $index++;
    //     // }
    //     // return $data;

    // }


    function resolveConsultantDefinitionDetailFlatModel($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!AuthRole::CheckAccessibility("ConsultantDefinitionDetail")) {
            return [];
        }
        $startOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $endOfWeek = (isset($args['next_week']) && ($args['next_week'] === true)) ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

        $tempDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_from']) : Carbon::parse($startOfWeek);
        $finishDate = isset($args['session_date_from']) ?  Carbon::create($args['session_date_to']) : Carbon::parse($endOfWeek);


        $branch_id = auth()->guard('api')->user()->branch_id;
        $branch_class_ids = BranchClassRoom::where('deleted_at', null)
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->pluck('id');
        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('deleted_at', null)
            ->where(function ($query) use ($args, $branch_id, $branch_class_ids, $startOfWeek, $endOfWeek) {
                if (isset($args['consultant_id']))
                    $query->where('consultant_id', $args['consultant_id']);
                if ($branch_class_ids) {
                    $query->whereIn('branch_class_room_id', $branch_class_ids);
                }

                // if (isset($args['branch_class_room_id'])) {
                //     $query->where('branch_class_room_id', $args['branch_class_room_id']);
                // } 
                // else {
                //     $query->whereHas('branchClassRoom.branch', function ($query) use ($branch_id) {
                //         if (isset($branch_id))
                //             return $query->whereIn('id', $branch_id);
                //     })
                //         ->with('branchClassRoom.branch');
                // }
                // if (isset($args['session_date_from'])) $query->where('session_date', '>=', $args['session_date_from']);
                // if (isset($args['session_date_to'])) $query->where('session_date', '<=', $args['session_date_to']);
                $query->where('session_date', '>=', $startOfWeek);
                $query->where('session_date', '<=', $endOfWeek);
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
            })->with(['user', 'consultant', 'branchClassRoom', 'compensatoryOfDefinitionDetail'])
            ->orderBy('session_date', 'asc')->get();

        $data = [];
        $index = 0;

        //Log::info("fth:".Carbon::parse($tempDate))->copy()->format("Y-m-d");

        while (($tempDate <= $finishDate) && ($index <= 6)) {
            $data[] = [
                "date" => Carbon::parse($tempDate)->copy()->format("Y-m-d"),
                "details" => $this->getDateData($ConsultantDefinitionDetail, $tempDate)
            ];
            $tempDate = $tempDate->addDays(1);
            $index++;
        }
        return $data;
    }

    function getDateData($consultantDefinitionDetail, Carbon $session_date_from)
    {
        //Log::info("session date is:" . $session_date_from->format("Y-m-d"));
        $result = $consultantDefinitionDetail
            ->where('session_date', $session_date_from->format("Y-m-d"))
            ->sortBy('start_hour')
            ->map(function (ConsultantDefinitionDetail $singlerecord) {
                return [
                    "id" => $singlerecord->id,
                    "consultant_id" => $singlerecord->consultant_id,
                    "student_id" => $singlerecord->student_id,
                    "compensatory_of_definition_detail_id" => isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->id : 0,
                    "compensatory_of_definition_detail_session_date" => isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->session_date : "",
                    "compensatory_of_definition_detail_start_hour" => isset($singlerecord->compensatoryOfDefinitionDetail) ?  $singlerecord->compensatoryOfDefinitionDetail->start_hour : "",
                    "compensatory_of_definition_detail_end_hour" => isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->end_hour : "",
                    "branch_class_room_id" => $singlerecord->branch_class_room_id,
                    "consultant_test_id" => $singlerecord->consultant_test_id,
                    "user_id" => $singlerecord->user_id,
                    "user_first_name" => $singlerecord->user->first_name,
                    "user_last_name" => $singlerecord->user->last_name,
                    "user_email" => $singlerecord->user->email,
                    "start_hour" => $singlerecord->start_hour,
                    "end_hour" => $singlerecord->end_hour,
                    "session_date" => $singlerecord->session_date,
                    "student_status" => $singlerecord->student_status,
                    "absent_present_description" => $singlerecord->absent_present_description,
                    "test_description" => $singlerecord->test_description,
                    "step" => $singlerecord->step,
                    "consultant" => $singlerecord->consultant,
                    "consultant_first_name" => $singlerecord->consultant->first_name,
                    "consultant_last_name" => $singlerecord->consultant->last_name,
                    "consultant_email" => $singlerecord->consultant->email,
                    "branchClassRoom_id" => isset($singlerecord->branch_class_room_id) ? 0 : null,
                    "branchClassRoom_name" => isset($singlerecord->branchClassRoom->name) ? $singlerecord->branchClassRoom->name : null,
                    "user_student_status_full_name" => isset($singlerecord->userStudentStatus) ? $singlerecord->userStudentStatus->first_name . " " . $singlerecord->userStudentStatus->last_name : null,
                    "student_status_updated_at" => $singlerecord->student_status_updated_at,
                    "compensatory_meet" => $singlerecord->compensatory_meet,
                    "single_meet" => $singlerecord->single_meet,
                    "remote" => $singlerecord->remote,
                ];
            });

        return  $result;
    }
}
