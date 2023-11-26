<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\BranchClassRoom;
use App\Models\ConsultantDefinitionDetail;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Carbon\Carbon;
use AuthRole;
use Log;

final class GetConsultantDefinitionDetailsReport
{

    function resolveConsultantDefinitionDetailGeneralReport($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!AuthRole::CheckAccessibility("ConsultantDefinitionDetailReport")) {
            return [];
        }

        $branch_id = auth()->guard('api')->user()->branch_id;
        $branch_class_ids = BranchClassRoom::where('deleted_at', null)
            ->where(function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->pluck('id');
        $consultants = User::where('group_id', getenv('CONSULTANT_GORUP_ID'))
            ->where(function ($query) use ($args, $branch_id, $branch_class_ids) {
                if (isset($args['consultant_id']))
                    $query->where('id', $args['consultant_id']);
                if ($branch_id) {
                    $query->whereIn('branch_id', $branch_id);
                }
            })->select("id","first_name","last_name")
            ->get();

        // Log::info("consultants are:" . json_encode($consultants));

        foreach ($consultants as $consultant) {

            $ConsultantDefinitionDetail = "";
            $consultant_id=$consultant['id'];
            $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('deleted_at', null)
                ->where(function ($query) use ($args, $branch_id, $branch_class_ids, $consultant_id ) {
                    if (isset( $consultant_id))
                        $query->where('consultant_id',  $consultant_id);
                    if ($branch_class_ids) {
                        $query->whereIn('branch_class_room_id', $branch_class_ids);
                    }

                    //if (isset($args['consultant_test_id'])) $query->where('consultant_test_id', $args['consultant_test_id']);
                    if (isset($args['user_id'])) $query->where('user_id', $args['user_id']);
                    if (isset($args['session_date_from'])) $query->where('session_date', '>=', $args['session_date_from']);
                    if (isset($args['session_date_to'])) $query->where('session_date', '<=', $args['session_date_to']);
                    if (isset($args['start_hour_from'])) $query->where('start_hour', '>=', $args['start_hour_from']);
                    if (isset($args['start_hour_to'])) $query->where('start_hour', '<=', $args['start_hour_to']);
                    if (isset($args['end_hour_from'])) $query->where('end_hour', '>=', $args['end_hour_from']);
                    if (isset($args['end_hour_to'])) $query->where('end_hour', '<=', $args['end_hour_to']);
                    if (isset($args['student_status'])) $query->whereIn('student_status', $args['student_status']);
                    if (isset($args['student_id'])) $query->where('student_id', $args['student_id']);
                    if (isset($args['absent_present_description'])) $query->where('absent_present_description', $args['absent_present_description']);
                    if (isset($args['test_description'])) $query->where('test_description', $args['test_description']);
                    if (isset($args['step'])) $query->where('step', $args['step']);
                })
                //->with(['user', 'consultant', 'branchClassRoom'])            
                ->select('id','consultant_id', 'student_id', 'student_status', 'step', 'session_status', 'consultant_status')
                ->orderBy('session_date', 'asc')
                ->get();

         //Log::info("ConsultantDefinitionDetail are:" . json_encode($ConsultantDefinitionDetail));


            $data[] = [
                "consultant_fullname" => $consultant['first_name'] ."  " . $consultant['last_name'], 
                "total_consultant_students" => $this->get_total_student_of_consultant($ConsultantDefinitionDetail),
                "total_consultant_definition" => $this->get_consultant_definition($ConsultantDefinitionDetail),
                // "empirical_student_total" => 6,
                // "humanities_student_total" => 2,
                // "mathematics_student_total" => 2,
                "total_student_present_hours" => $this->get_total_student_present_hours($ConsultantDefinitionDetail),
                "total_student_present" => $this->get_total_student_present($ConsultantDefinitionDetail),
                "total_student_absence_hours" => $this->get_total_student_absence_hours($ConsultantDefinitionDetail),
                "total_student_absence" => $this->get_total_absence_student($ConsultantDefinitionDetail),
                "total_student_delay_hours" => $this->get_total_student_delay_hours($ConsultantDefinitionDetail),
                "total_student_delay" => $this->get_total_delay_student($ConsultantDefinitionDetail),

                "total_consultant_obligation_hours" => $this->get_total_consultant_obligation_hours($ConsultantDefinitionDetail),
                "total_consultant_present_hours" => $this->get_total_consultant_present_hours($ConsultantDefinitionDetail),
                "total_consultant_absence_hours" => $this->get_total_consultant_absence_hours($ConsultantDefinitionDetail),
                "total_consultant_earlier_hours" => $this->get_total_consultant_earlier_hours($ConsultantDefinitionDetail),


                "details" => clone $ConsultantDefinitionDetail
            ];
        }

        return $data;
    }

    function get_total_student_of_consultant($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_student_of_consultant = $ConsultantDefinitionDetail_copy->pluck('student_id')->unique()->count();
        return $total_student_of_consultant;
    }
    function get_consultant_definition($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $consultant_definition = $ConsultantDefinitionDetail_copy->count();
        return $consultant_definition;
    }

    function get_total_student_present_hours($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_student_present_hours = $ConsultantDefinitionDetail_copy->where('student_status', "present")->sum('step');
        //Log::info("total student are: " . json_encode( $total_student_present_hours)); 
        $total_student_present_hours = (round($total_student_present_hours / 60, 2));
        return $total_student_present_hours;
    }
    function get_total_student_present($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_student_present = $ConsultantDefinitionDetail_copy->where('student_status', "present")->count();
        //Log::info("total student are: " . json_encode($total_student));      
        return $total_student_present;
    }

    function get_total_student_absence_hours($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_student_absence_hours = $ConsultantDefinitionDetail_copy->where('student_status', "absent")->sum('step');
        //Log::info("total student are: " . json_encode($total_student)); 
        $total_student_absence_hours = round($total_student_absence_hours / 60, 2);
        return $total_student_absence_hours;
    }

    function get_total_student_delay_hours($ConsultantDefinitionDetail)
    {
        $total_hour = 0;
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_dellay5_student = $ConsultantDefinitionDetail_copy->where('student_status', "dellay5")->count();
        $total_dellay10_student = $ConsultantDefinitionDetail_copy->where('student_status', "dellay10")->count();
        $total_dellay15_student = $ConsultantDefinitionDetail_copy->where('student_status', "dellay15")->count();
        $total_dellay15more_student = $ConsultantDefinitionDetail_copy->where('student_status', "dellay15more")->count();
        //Log::info("total student are: " . json_encode($total_student));      
        $total_hour += ($total_dellay5_student * 5);
        $total_hour += ($total_dellay10_student * 10);
        $total_hour += ($total_dellay15_student * 15);
        $total_hour += ($total_dellay15more_student * 20);
        $total_hour = round(($total_hour / 60), 2);
        return $total_hour;
    }

    function get_total_absence_student($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_absence_student = $ConsultantDefinitionDetail_copy->where('student_status', "absent")->count();
        //Log::info("total student are: " . json_encode($total_student));      
        return $total_absence_student;
    }

    function get_total_delay_student($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy_all = clone $ConsultantDefinitionDetail;

        $searchTerms = ['dellay5', 'dellay10', 'dellay15', 'dellay15more'];

        $total_delay_student = $ConsultantDefinitionDetail_copy_all->filter(function ($ConsultantDefinitionDetail_copy) use ($searchTerms) {
            return in_array($ConsultantDefinitionDetail_copy['student_status'], $searchTerms);
        });

        $count = $total_delay_student->count();

        return  $count;
    }

    function get_total_consultant_obligation_hours($ConsultantDefinitionDetail)
    {
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_consultant_obligation_hours = $ConsultantDefinitionDetail_copy->sum('step');
        $total_consultant_obligation_hours =  round($total_consultant_obligation_hours / 60, 2);
        //Log::info("total student are: " . json_encode($total_student));      
        return $total_consultant_obligation_hours;
    }
    function get_total_consultant_present_hours($ConsultantDefinitionDetail)
    {

        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;
        $total_consultant_present_hours = $ConsultantDefinitionDetail_copy
            ->where('consultant_status', 'present')
            ->sum('step');
        $total_consultant_present_hours = round($total_consultant_present_hours / 60);
        //Log::info("total student are: " . json_encode($total_student));      
        return $total_consultant_present_hours;
    }

    function get_total_consultant_earlier_hours($ConsultantDefinitionDetail)
    {
        $total_hour = 0;
        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;

        $total_earlier5_student = $ConsultantDefinitionDetail_copy->where('session_status', "earlier_5min_finished")->count();
        $total_earlier10_student = $ConsultantDefinitionDetail_copy->where('session_status', "earlier_10min_finished")->count();
        $total_earlier15_student = $ConsultantDefinitionDetail_copy->where('session_status', "earlier_15min_finished")->count();
        $total_earlier15more_student = $ConsultantDefinitionDetail_copy->where('session_status', "earlier_15min_more_finished")->count();
        //Log::info("total student are: " . json_encode($total_student));      
        $total_hour += ($total_earlier5_student * 5);
        $total_hour += ($total_earlier10_student * 10);
        $total_hour += ($total_earlier15_student * 15);
        $total_hour += ($total_earlier15more_student * 20);
        $total_hour = round($total_hour / 60, 2);
        return $total_hour;
    }
    function get_total_consultant_absence_hours($ConsultantDefinitionDetail)
    {

        $ConsultantDefinitionDetail_copy = clone $ConsultantDefinitionDetail;
        $total_consultant_absence_hours = $ConsultantDefinitionDetail_copy
            ->where('consultant_status', 'absent')
            ->sum('step');
        $total_consultant_absence_hours =  round($total_consultant_absence_hours / 60, 2);
        //Log::info("total student are: " . json_encode($total_student));      
        return $total_consultant_absence_hours;
    }
}
