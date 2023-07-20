<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

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
        $ConsultantDefinitionDetails = ConsultantDefinitionDetail::where('deleted_at', null)
            ->where(function ($query) use ($args,  $target_date ,$branch_id) {
                if (isset($args['consultant_id']))
                    $query->where('consultant_id', $args['consultant_id']);
                
                $query->where('session_date', '=',  $target_date );
                
            })->with(['user', 'consultant', 'branchClassRoom'])                       
            ->orderBy('consultant_id', 'asc')
            ->get();
           // Log::info("the data is:" . json_encode($ConsultantDefinitionDetails));

        $data = [];
        $index = 0;
        $consultant_id=0;
        foreach($ConsultantDefinitionDetails as $ConsultantDefinitionDetail){
            
            if($ConsultantDefinitionDetail->consultant_id=== $consultant_id ){
                continue;
            }
            $consultant_id=$ConsultantDefinitionDetail->consultant_id;
            $data[] = [
                "consultant" => $ConsultantDefinitionDetail->consultant,               
                //"consultant_name" => $ConsultantDefinitionDetail->consultant->first_name . " " .$ConsultantDefinitionDetail->consultant->last_name,               
                "times" => $this->getDateData($ConsultantDefinitionDetails,$ConsultantDefinitionDetail->consultant_id)
            ];
           
            $index++;
        }
        return $data;
    }

    function getDateData($consultantDefinitionDetails,$consultant_id)
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
                ];
            });

        return  $result;
    }
}
