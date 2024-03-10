<?php

namespace App\GraphQL\Queries\ConsultantReport;

use App\Models\ConsultantReport;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use App\Models\User;
use AuthRole;
use Carbon\Carbon;
use Log;


final class GetConsultantReport
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
   
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantReport($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        // Log::info(" consultants id are :" . isset($args['consultant_id']));


        // if(isset(($args['consultant_id']) && ($args['consultant_id']===-2)))
        // {
        //     return null;
        // }
        if (AuthRole::CheckAccessibility("ConsultantReport")) {

            $consultants = User::where('group_id', 6)
                ->where(function ($query) use ($args) {
                    if (isset($args['consultant_id'])) {
                        $query->where('id', $args['consultant_id']);
                    }
                })
                ->get();

            // Log::info(" consultants id are :" . json_encode( $consultants));

            $today = Carbon::now()->format("Y-m-d");           
            $data=[];
            //$total=[];


            $total=[
                "sum_students_registered" =>0,

                "sum_students_major_humanities" =>0,
                "sum_students_major_experimental" =>0,
                "sum_students_major_mathematics" =>0,
                "sum_students_major_art" =>0,
                "sum_students_major_other" =>0,

                "sum_students_education_level_6" =>0,
                "sum_students_education_level_7" =>0,
                "sum_students_education_level_8" =>0,
                "sum_students_education_level_9" =>0,
                "sum_students_education_level_10" =>0,
                "sum_students_education_level_11" =>0,
                "sum_students_education_level_12" =>0,
                "sum_students_education_level_13" =>0,
                "sum_students_education_level_14" =>0,

                "sum_is_defined_consultant_session" =>0,
                "sum_is_defined_consultant_session_in_minutes" =>0,
                "sum_is_filled_consultant_session" =>0,
                "sum_is_filled_consultant_session_in_minutes" =>0,

                "sum_student_status_absent" =>0,
                "sum_student_status_present" =>0,
                "sum_student_status_no_action" =>0,

                "sum_student_status_dellay5" =>0,
                "sum_student_status_dellay10" =>0,
                "sum_student_status_dellay15" =>0,
                "sum_student_status_dellay15more" =>0,

                "sum_session_status_no_action" =>0,
                "sum_session_status_earlier_5min_finished" =>0,
                "sum_session_status_earlier_10min_finished" =>0,
                "sum_session_status_earlier_15min_finished" =>0,
                "sum_session_status_earlier_15min_more_finished" =>0,

                "sum_session_status_later_5min_started" =>0,
                "sum_session_status_later_10min_started" =>0,
                "sum_session_status_later_15min_started" =>0,
                "sum_session_status_later_15min_more_started" =>0,

                "sum_consultant_status_no_action" =>0,
                "sum_consultant_status_absent" =>0,
                "sum_consultant_status_present" =>0,

                "sum_consultant_status_dellay5" =>0,
                "sum_consultant_status_dellay10" =>0,
                "sum_consultant_status_dellay15" =>0,
                "sum_consultant_status_dellay15more" =>0,

                "sum_compensatory_meet_1" =>0,
                "sum_single_meet_1" =>0,
                "sum_remote_1" =>0,

                "sum_financial_manager_status_approved" =>0,
                "sum_financial_manager_status_pending" =>0,

                "sum_financial_financial_status_approved" =>0,
                "sum_financial_financial_status_pending" =>0,
                "sum_financial_financial_status_semi_approved" =>0,

                "sum_financial_student_status_ok" =>0,
                "sum_financial_student_status_refused" =>0,
                "sum_financial_student_status_fired" =>0,
                "sum_financial_student_status_financial_pending" =>0,
                "sum_financial_student_status_fire_pending" =>0,
                "sum_financial_student_status_refuse_pending" =>0,

                "sum_financial_financial_refused_status_not_returned" =>0,
                "sum_financial_financial_refused_status_returned" =>0,
                "sum_financial_financial_refused_status_noMoney" =>0,


            ];    
                  

            foreach ($consultants as $consultant) {
                $consultant_report = new ConsultantReport;
                $ConsultantReport = ConsultantReport::where('deleted_at', null)->where('consultant_id', $consultant['id']);
                Log::info("the date are:" . $args['static_date_from'] . " and to is:" .$args['static_date_to']);
                isset($args['static_date_from']) ? $ConsultantReport->where('statical_date', '>=', $args['static_date_from']) : null;
                isset($args['static_date_to']) ? $ConsultantReport->where('statical_date', '<=', $args['static_date_to']) : null;

                $ConsultantReports = $ConsultantReport->get();
                Log::info("the records are:" . json_encode( $ConsultantReports));


                foreach ($ConsultantReports as $ConsultantReport) {
                    $consultant_report->consultant_id = $consultant['id'];
                    $consultant_report->sum_students_registered += $ConsultantReport['sum_students_registered'];

                    $consultant_report->sum_students_major_humanities += $ConsultantReport['sum_students_major_humanities'];
                    $consultant_report->sum_students_major_experimental += $ConsultantReport['sum_students_major_experimental'];
                    $consultant_report->sum_students_major_mathematics += $ConsultantReport['sum_students_major_mathematics'];
                    $consultant_report->sum_students_major_art += $ConsultantReport['sum_students_major_art'];
                    $consultant_report->sum_students_major_other += $ConsultantReport['sum_students_major_other'];


                    $consultant_report->sum_students_education_level_6 += $ConsultantReport['sum_students_education_level_6'];
                    $consultant_report->sum_students_education_level_7 += $ConsultantReport['sum_students_education_level_7'];
                    $consultant_report->sum_students_education_level_8 += $ConsultantReport['sum_students_education_level_8'];
                    $consultant_report->sum_students_education_level_9 += $ConsultantReport['sum_students_education_level_9'];
                    $consultant_report->sum_students_education_level_10 += $ConsultantReport['sum_students_education_level_10'];
                    $consultant_report->sum_students_education_level_11 += $ConsultantReport['sum_students_education_level_11'];
                    $consultant_report->sum_students_education_level_12 += $ConsultantReport['sum_students_education_level_12'];
                    $consultant_report->sum_students_education_level_13 += $ConsultantReport['sum_students_education_level_13'];
                    $consultant_report->sum_students_education_level_14 += $ConsultantReport['sum_students_education_level_14'];


                    $consultant_report->sum_is_defined_consultant_session += $ConsultantReport['sum_is_defined_consultant_session'];
                    $consultant_report->sum_is_defined_consultant_session_in_minutes += $ConsultantReport['sum_is_defined_consultant_session_in_minutes'];
                    $consultant_report->sum_is_filled_consultant_session += $ConsultantReport['sum_is_filled_consultant_session'];
                    $consultant_report->sum_is_filled_consultant_session_in_minutes += $ConsultantReport['sum_is_filled_consultant_session_in_minutes'];


                    $consultant_report->sum_student_status_absent += $ConsultantReport['sum_student_status_absent'];
                    $consultant_report->sum_student_status_present += $ConsultantReport['sum_student_status_present'];
                    $consultant_report->sum_student_status_no_action += $ConsultantReport['sum_student_status_no_action'];

                    $consultant_report->sum_student_status_dellay5 += $ConsultantReport['sum_student_status_dellay5'];
                    $consultant_report->sum_student_status_dellay10 += $ConsultantReport['sum_student_status_dellay10'];
                    $consultant_report->sum_student_status_dellay15 += $ConsultantReport['sum_student_status_dellay15'];
                    $consultant_report->sum_student_status_dellay15more += $ConsultantReport['sum_student_status_dellay15more'];

                    $consultant_report->sum_session_status_no_action += $ConsultantReport['sum_session_status_no_action'];
                    $consultant_report->sum_session_status_earlier_5min_finished += $ConsultantReport['sum_session_status_earlier_5min_finished'];
                    $consultant_report->sum_session_status_earlier_10min_finished += $ConsultantReport['sum_session_status_earlier_10min_finished'];
                    $consultant_report->sum_session_status_earlier_15min_finished += $ConsultantReport['sum_session_status_earlier_15min_finished'];
                    $consultant_report->sum_session_status_earlier_15min_more_finished += $ConsultantReport['sum_session_status_earlier_15min_more_finished'];

                    $consultant_report->sum_session_status_later_5min_started += $ConsultantReport['sum_session_status_later_5min_started'];
                    $consultant_report->sum_session_status_later_10min_started += $ConsultantReport['sum_session_status_later_10min_started'];
                    $consultant_report->sum_session_status_later_15min_started += $ConsultantReport['sum_session_status_later_15min_started'];
                    $consultant_report->sum_session_status_later_15min_more_started += $ConsultantReport['sum_session_status_later_15min_more_started'];

                    $consultant_report->sum_consultant_status_no_action += $ConsultantReport['sum_consultant_status_no_action'];
                    $consultant_report->sum_consultant_status_absent += $ConsultantReport['sum_consultant_status_absent'];
                    $consultant_report->sum_consultant_status_present += $ConsultantReport['sum_consultant_status_present'];

                    $consultant_report->sum_consultant_status_dellay5 += $ConsultantReport['sum_consultant_status_dellay5'];
                    $consultant_report->sum_consultant_status_dellay10 += $ConsultantReport['sum_consultant_status_dellay10'];
                    $consultant_report->sum_consultant_status_dellay15 += $ConsultantReport['sum_consultant_status_dellay15'];
                    $consultant_report->sum_consultant_status_dellay15more += $ConsultantReport['sum_consultant_status_dellay15more'];

                    $consultant_report->sum_compensatory_meet_1 += $ConsultantReport['sum_compensatory_meet_1'];
                    $consultant_report->sum_single_meet_1 += $ConsultantReport['sum_single_meet_1'];
                    $consultant_report->sum_remote_1 += $ConsultantReport['sum_remote_1'];


                    $consultant_report->sum_financial_manager_status_approved += $ConsultantReport['sum_financial_manager_status_approved'];
                    $consultant_report->sum_financial_manager_status_pending += $ConsultantReport['sum_financial_manager_status_pending'];
                    $consultant_report->sum_financial_financial_status_approved += $ConsultantReport['sum_financial_financial_status_approved'];
                    $consultant_report->sum_financial_financial_status_pending += $ConsultantReport['sum_financial_financial_status_pending'];
                    $consultant_report->sum_financial_financial_status_semi_approved += $ConsultantReport['sum_financial_financial_status_semi_approved'];
                    $consultant_report->sum_financial_student_status_ok += $ConsultantReport['sum_financial_student_status_ok'];
                    $consultant_report->sum_financial_student_status_refused += $ConsultantReport['sum_financial_student_status_refused'];
                    $consultant_report->sum_financial_student_status_fired += $ConsultantReport['sum_financial_student_status_fired'];

                    $consultant_report->sum_financial_student_status_financial_pending += $ConsultantReport['sum_financial_student_status_financial_pending'];
                    $consultant_report->sum_financial_student_status_fire_pending += $ConsultantReport['sum_financial_student_status_fire_pending'];
                    $consultant_report->sum_financial_student_status_refuse_pending += $ConsultantReport['sum_financial_student_status_refuse_pending'];
                    $consultant_report->sum_financial_financial_refused_status_not_returned += $ConsultantReport['sum_financial_financial_refused_status_not_returned'];
                    $consultant_report->sum_financial_financial_refused_status_returned += $ConsultantReport['sum_financial_financial_refused_status_returned'];
                    $consultant_report->sum_financial_financial_refused_status_noMoney += $ConsultantReport['sum_financial_financial_refused_status_noMoney'];
                                   
                


                    $total['sum_students_registered'] += $ConsultantReport['sum_students_registered'];

                    $total['sum_students_major_humanities'] += $ConsultantReport['sum_students_major_humanities'];
                    $total['sum_students_major_experimental'] += $ConsultantReport['sum_students_major_experimental'];
                    $total['sum_students_major_mathematics'] += $ConsultantReport['sum_students_major_mathematics'];
                    $total['sum_students_major_art'] += $ConsultantReport['sum_students_major_art'];
                    $total['sum_students_major_other'] += $ConsultantReport['sum_students_major_other'];


                    $total['sum_students_education_level_6'] += $ConsultantReport['sum_students_education_level_6'];
                    $total['sum_students_education_level_7'] += $ConsultantReport['sum_students_education_level_7'];
                    $total['sum_students_education_level_8']+= $ConsultantReport['sum_students_education_level_8'];
                    $total['sum_students_education_level_9'] += $ConsultantReport['sum_students_education_level_9'];
                    $total['sum_students_education_level_10'] += $ConsultantReport['sum_students_education_level_10'];
                    $total['sum_students_education_level_11'] += $ConsultantReport['sum_students_education_level_11'];
                    $total['sum_students_education_level_12'] += $ConsultantReport['sum_students_education_level_12'];
                    $total['sum_students_education_level_13'] += $ConsultantReport['sum_students_education_level_13'];
                    $total['sum_students_education_level_14'] += $ConsultantReport['sum_students_education_level_14'];


                    $total['sum_is_defined_consultant_session'] += $ConsultantReport['sum_is_defined_consultant_session'];
                    $total['sum_is_defined_consultant_session_in_minutes'] += $ConsultantReport['sum_is_defined_consultant_session_in_minutes'];
                    $total['sum_is_filled_consultant_session'] += $ConsultantReport['sum_is_filled_consultant_session'];
                    $total['sum_is_filled_consultant_session_in_minutes'] += $ConsultantReport['sum_is_filled_consultant_session_in_minutes'];


                    $total['sum_student_status_absent'] += $ConsultantReport['sum_student_status_absent'];
                    $total['sum_student_status_present'] += $ConsultantReport['sum_student_status_present'];
                    $total['sum_student_status_no_action'] += $ConsultantReport['sum_student_status_no_action'];

                    $total['sum_student_status_dellay5'] += $ConsultantReport['sum_student_status_dellay5'];
                    $total['sum_student_status_dellay10'] += $ConsultantReport['sum_student_status_dellay10'];
                    $total['sum_student_status_dellay15'] += $ConsultantReport['sum_student_status_dellay15'];
                    $total['sum_student_status_dellay15more'] += $ConsultantReport['sum_student_status_dellay15more'];

                    $total['sum_session_status_no_action'] += $ConsultantReport['sum_session_status_no_action'];
                    $total['sum_session_status_earlier_5min_finished'] += $ConsultantReport['sum_session_status_earlier_5min_finished'];
                    $total['sum_session_status_earlier_10min_finished'] += $ConsultantReport['sum_session_status_earlier_10min_finished'];
                    $total['sum_session_status_earlier_15min_finished'] += $ConsultantReport['sum_session_status_earlier_15min_finished'];
                    $total['sum_session_status_earlier_15min_more_finished'] += $ConsultantReport['sum_session_status_earlier_15min_more_finished'];

                    $total['sum_session_status_later_5min_started'] += $ConsultantReport['sum_session_status_later_5min_started'];
                    $total['sum_session_status_later_10min_started'] += $ConsultantReport['sum_session_status_later_10min_started'];
                    $total['sum_session_status_later_15min_started'] += $ConsultantReport['sum_session_status_later_15min_started'];
                    $total['sum_session_status_later_15min_more_started'] += $ConsultantReport['sum_session_status_later_15min_more_started'];

                    $total['sum_consultant_status_no_action'] += $ConsultantReport['sum_consultant_status_no_action'];
                    $total['sum_consultant_status_absent'] += $ConsultantReport['sum_consultant_status_absent'];
                    $total['sum_consultant_status_present'] += $ConsultantReport['sum_consultant_status_present'];

                    $total['sum_consultant_status_dellay5'] += $ConsultantReport['sum_consultant_status_dellay5'];
                    $total['sum_consultant_status_dellay10'] += $ConsultantReport['sum_consultant_status_dellay10'];
                    $total['sum_consultant_status_dellay15'] += $ConsultantReport['sum_consultant_status_dellay15'];
                    $total['sum_consultant_status_dellay15more'] += $ConsultantReport['sum_consultant_status_dellay15more'];

                    $total['sum_compensatory_meet_1'] += $ConsultantReport['sum_compensatory_meet_1'];
                    $total['sum_single_meet_1'] += $ConsultantReport['sum_single_meet_1'];
                    $total['sum_remote_1'] += $ConsultantReport['sum_remote_1'];


                    $total['sum_financial_manager_status_approved'] += $ConsultantReport['sum_financial_manager_status_approved'];
                    $total['sum_financial_manager_status_pending'] += $ConsultantReport['sum_financial_manager_status_pending'];
                    $total['sum_financial_financial_status_approved'] += $ConsultantReport['sum_financial_financial_status_approved'];
                    $total['sum_financial_financial_status_pending'] += $ConsultantReport['sum_financial_financial_status_pending'];
                    $total['sum_financial_financial_status_semi_approved'] += $ConsultantReport['sum_financial_financial_status_semi_approved'];
                    $total['sum_financial_student_status_ok'] += $ConsultantReport['sum_financial_student_status_ok'];
                    $total['sum_financial_student_status_refused'] += $ConsultantReport['sum_financial_student_status_refused'];
                    $total['sum_financial_student_status_fired'] += $ConsultantReport['sum_financial_student_status_fired'];

                    $total['sum_financial_student_status_financial_pending'] += $ConsultantReport['sum_financial_student_status_financial_pending'];
                    $total['sum_financial_student_status_fire_pending'] += $ConsultantReport['sum_financial_student_status_fire_pending'];
                    $total['sum_financial_student_status_refuse_pending'] += $ConsultantReport['sum_financial_student_status_refuse_pending'];
                    $total['sum_financial_financial_refused_status_not_returned'] += $ConsultantReport['sum_financial_financial_refused_status_not_returned'];
                    $total['sum_financial_financial_refused_status_returned'] += $ConsultantReport['sum_financial_financial_refused_status_returned'];
                    $total['sum_financial_financial_refused_status_noMoney'] += $ConsultantReport['sum_financial_financial_refused_status_noMoney'];
                                   
                }

                //$this->add_to_total($consultant_report);
                //Log::info(" consultant_fullname id are :" .$consultant['first_name']. ' ' . $consultant['last_name']);

                $data[] = [
                    "consultant_id" => $consultant['id'],
                    "consultant_fullname" => $consultant['first_name']. ' ' . $consultant['last_name'],
                    "consultant_statics" =>  $consultant_report
                ];
            }
            $data[]=[
                "consultant_id" => 0,
                "consultant_fullname" =>"جمع کل",
                "consultant_statics" =>   $total
            ];
            return $data;
        }
        return ConsultantReport::where('deleted_at', null)
            ->where('id', -1);
    }

    // function add_to_total(ConsultantReport  $consultant_report){

    //     foreach($consultant_report as $consultant_report_tmp){

    //         Log::info("total are:" .$consultant_report_tmp );

    //         $total['sum_students_registered']  += $consultant_report_tmp['sum_students_registered'];
    //     }

    //     return $total;


    // }

}
