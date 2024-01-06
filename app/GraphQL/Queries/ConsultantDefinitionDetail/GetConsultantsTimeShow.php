<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\BranchClassRoom;
use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Carbon\Carbon;
use AuthRole;
use Log;

final class GetConsultantsTimeShow
{

    function resolveConsultantsTimeShow($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!AuthRole::CheckAccessibility("GetConsultantsTimeShow")) {
            return [];
        }
        $target_date = isset($args['target_date'])  ? $args['target_date']  : Carbon::now()->format("Y-m-d");

        $branch_id = auth()->guard('api')->user()->branch_id;

       //Log::info("branch_id are:" . json_encode($branch_id) );

        $branch_class_ids=BranchClassRoom::where('deleted_at', null)
        ->where(function($query) use($branch_id){
            if($branch_id){
                $query->where('branch_id',$branch_id);
            }
        })  
       // ->where('branch_id',5)    
        ->pluck('id');
        //Log::info("classes are:" . json_encode($branch_class_ids) );

        $ConsultantDefinitionDetails = ConsultantDefinitionDetail::where('deleted_at', null)
            ->where(function ($query) use ($args,  $target_date, $branch_class_ids) {
                if (isset($args['consultant_id']))
                    $query->where('consultant_id', $args['consultant_id']);

                if ($branch_class_ids) {
                    $query->whereIn('branch_class_room_id', $branch_class_ids);
                }

                $query->where('session_date', '=',  $target_date);
            })->with(['user', 'consultant', 'branchClassRoom',"userStudentStatus","financial"])
            ->orderBy('consultant_id', 'asc')
            ->get();
         //Log::info("the data is:" . json_encode($ConsultantDefinitionDetails));

        $data = [];
        $index = 0;
        $consultant_id = 0;
        foreach ($ConsultantDefinitionDetails as $ConsultantDefinitionDetail) {

            if ($ConsultantDefinitionDetail->consultant_id === $consultant_id) {
                continue;
            }
            $consultant_id = $ConsultantDefinitionDetail->consultant_id;
            $data[] = [
                "consultant" => $ConsultantDefinitionDetail->consultant,
                //"consultant_name" => $ConsultantDefinitionDetail->consultant->first_name . " " .$ConsultantDefinitionDetail->consultant->last_name,               
                "details" => $this->getDateData($ConsultantDefinitionDetails, $ConsultantDefinitionDetail->consultant_id)
            ];

            $index++;
        }
        return $data;
    }

    function getDateData($consultantDefinitionDetails, $consultant_id)
    {
        //Log::info("session date is:" . $session_date_from->format("Y-m-d"));
        $result = $consultantDefinitionDetails
            ->where('consultant_id', $consultant_id)
            ->sortBy('start_hour')
            ->map(function (ConsultantDefinitionDetail $singlerecord) {
                return [
                    "id" => $singlerecord->id,
                    "consultant_id" => $singlerecord->consultant_id,
                    "student_id" => $singlerecord->student_id,
                    "compensatory_of_definition_detail_id" => isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->id : 0,
                    "compensatory_of_definition_detail_session_date" =>isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->session_date : "",
                    "compensatory_of_definition_detail_start_hour" => isset($singlerecord->compensatoryOfDefinitionDetail) ?  $singlerecord->compensatoryOfDefinitionDetail->start_hour : "",
                    "compensatory_of_definition_detail_end_hour" =>isset($singlerecord->compensatoryOfDefinitionDetail) ? $singlerecord->compensatoryOfDefinitionDetail->end_hour : "",
                    

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
                    "copy_to_next_week" => $singlerecord->copy_to_next_week,
                    "absent_present_description" => $singlerecord->absent_present_description,
                    "test_description" => $singlerecord->test_description,
                    "step" => $singlerecord->step,
                    "consultant" => $singlerecord->consultant,
                    "consultant_first_name" => $singlerecord->consultant->first_name,
                    "consultant_last_name" => $singlerecord->consultant->last_name,
                    "consultant_email" => $singlerecord->consultant->email,
                    "branchClassRoom_id" => isset($singlerecord->branch_class_room_id) ? 0 : null,
                    "branchClassRoom_name" => isset($singlerecord->branchClassRoom->name) ? $singlerecord->branchClassRoom->name : null,
                    "user_student_status_full_name" => isset($singlerecord->userStudentStatus) ? $singlerecord->userStudentStatus->first_name . " " .$singlerecord->userStudentStatus->last_name: null,
                    "student_status_updated_at" => $singlerecord->student_status_updated_at,
                    "compensatory_meet" => $singlerecord->compensatory_meet,
                    "single_meet" => $singlerecord->single_meet,
                    "remote" => $singlerecord->remote,
                    "consultant_financial" => $singlerecord->financial ,
                    
                ];
            });

        return  $result;
    }
}
