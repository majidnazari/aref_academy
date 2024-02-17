<?php

namespace App\GraphQL\Queries\ConsultantReport;

use App\Models\ConsultantReport;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
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

        if (AuthRole::CheckAccessibility("ConsultantReport")) {


            $today=Carbon::now()->format("Y-m-d");
            $ConsultantReport = ConsultantReport::where('deleted_at', null); //->orderBy('id','desc');   

            isset($args['consultant_id']) ? $ConsultantReport->where('consultant_id', $args['consultant_id']) : '';
            isset($args['static_date_from']) ? $ConsultantReport->where('statical_date','>=', $args['static_date_from']) : null;
            isset($args['static_date_to']) ? $ConsultantReport->where('statical_date','<=', $args['static_date_to']) : null;

            $ConsultantReports=$ConsultantReport->get();
        //     if($branch_id){
        //         //isset($args['branch_id']) ? $ConsultantReport->where('branch_id', $args['branch_id']) : $ConsultantReport->whereIn('branch_id', $branch_id);
        //         $ConsultantReport->where('branch_id',$branch_id);
        //     }
            
        //     //isset($args['branch_id']) ? $ConsultantReport->where('branch_id', $args['branch_id']) : '';
        //     isset($args['manager_status']) ? $ConsultantReport->where('manager_status', $args['manager_status']) : '';
            
        //     isset($args['financial_status']) ? $ConsultantReport->where('financial_status', $args['financial_status']) : '';
        //     isset($args['student_status']) ? $ConsultantReport->where('student_status', $args['student_status']) : '';
        //     isset($args['financial_refused_status']) ? $ConsultantReport->where('financial_refused_status', $args['financial_refused_status']) : '';
        //     isset($args['user_id_manager']) ? $ConsultantReport->where('user_id_manager', $args['user_id_manager']) : '';
        //     isset($args['user_id_financial']) ? $ConsultantReport->where('user_id_financial',  $args['user_id_financial']) : '';
        //     isset($args['user_id_student_status']) ? $ConsultantReport->where('user_id_student_status', $args['user_id_student_status']) : '';
        //     isset($args['description']) ? $ConsultantReport->where('description', $args['description']) : '';
        //     isset($args['date_from']) ? $ConsultantReport->where('created_at','>=', $args['date_from']) : '';
        //     isset($args['date_to']) ? $ConsultantReport->where('created_at','<=', $args['date_to']) : '';
        //    if (isset($args['total_present']) )
        //    {
        //     $ConsultantReport
        //     ->groupBy('student_id')
        //     ->havingRaw("COUNT(student_id) = ".$args['total_present']  );
        //     //    $consultantFinancial_copy = clone $ConsultantReport;
        //     //    $result=$this->find_total_present_in_consultant_fifancial($ConsultantReport,$args['total_present']);

        //    }

        $consultant_report=new ConsultantReport;

        foreach($ConsultantReports as $ConsultantReport){
            $consultant_report->sum_students_registered +=$ConsultantReport['sum_students_registered'];

            $consultant_report->sum_students_major_humanities +=$ConsultantReport['sum_students_major_humanities'];
            $consultant_report->sum_students_major_experimental +=$ConsultantReport['sum_students_major_experimental'];
            $consultant_report->sum_students_major_mathematics +=$ConsultantReport['sum_students_major_mathematics'];
            $consultant_report->sum_students_major_art +=$ConsultantReport['sum_students_major_art'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_major_other'];


            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_6'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_7'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_8'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_9'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_10'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_11'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_12'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_13'];
            $consultant_report->sum_students_major_other +=$ConsultantReport['sum_students_education_level_14'];


            $consultant_report->sum_is_defined_consultant_session +=$ConsultantReport['sum_is_defined_consultant_session'];
            $consultant_report->sum_is_defined_consultant_session_in_minutes +=$ConsultantReport['sum_is_defined_consultant_session_in_minutes'];
            $consultant_report->sum_is_filled_consultant_session +=$ConsultantReport['sum_is_filled_consultant_session'];
            $consultant_report->sum_is_filled_consultant_session_in_minutes +=$ConsultantReport['sum_is_filled_consultant_session_in_minutes'];


            $consultant_report->sum_student_status_absent +=$ConsultantReport['sum_student_status_absent'];
            $consultant_report->sum_student_status_present +=$ConsultantReport['sum_student_status_present'];
            $consultant_report->sum_student_status_no_action +=$ConsultantReport['sum_student_status_no_action'];

            $consultant_report->sum_student_status_dellay5 +=$ConsultantReport['sum_student_status_dellay5'];
            $consultant_report->sum_student_status_dellay10 +=$ConsultantReport['sum_student_status_dellay10'];
            $consultant_report->sum_student_status_dellay15 +=$ConsultantReport['sum_student_status_dellay15'];
            $consultant_report->sum_student_status_dellay15more +=$ConsultantReport['sum_student_status_dellay15more'];

            $consultant_report->sum_session_status_no_action +=$ConsultantReport['sum_session_status_no_action'];
            $consultant_report->sum_session_status_earlier_5min_finished +=$ConsultantReport['sum_session_status_earlier_5min_finished'];
            $consultant_report->sum_session_status_earlier_10min_finished +=$ConsultantReport['sum_session_status_earlier_10min_finished'];
            $consultant_report->sum_session_status_earlier_15min_finished +=$ConsultantReport['sum_session_status_earlier_15min_finished'];
            $consultant_report->sum_session_status_earlier_15min_more_finished +=$ConsultantReport['sum_session_status_earlier_15min_more_finished'];

            $consultant_report->sum_session_status_later_5min_started +=$ConsultantReport['sum_session_status_later_5min_started'];
            $consultant_report->sum_session_status_later_10min_started +=$ConsultantReport['sum_session_status_later_10min_started'];
            $consultant_report->sum_session_status_later_15min_started +=$ConsultantReport['sum_session_status_later_15min_started'];
            $consultant_report->sum_session_status_later_15min_more_started +=$ConsultantReport['sum_session_status_later_15min_more_started'];

            $consultant_report->sum_consultant_status_no_action +=$ConsultantReport['sum_consultant_status_no_action'];
            $consultant_report->sum_consultant_status_absent +=$ConsultantReport['sum_consultant_status_absent'];
            $consultant_report->sum_consultant_status_present +=$ConsultantReport['sum_consultant_status_present'];

            $consultant_report->sum_consultant_status_dellay5 +=$ConsultantReport['sum_consultant_status_dellay5'];
            $consultant_report->sum_consultant_status_dellay10 +=$ConsultantReport['sum_consultant_status_dellay10'];
            $consultant_report->sum_consultant_status_dellay15 +=$ConsultantReport['sum_consultant_status_dellay15'];
            $consultant_report->sum_consultant_status_dellay15more +=$ConsultantReport['sum_consultant_status_dellay15more'];

            $consultant_report->sum_compensatory_meet_1 +=$ConsultantReport['sum_compensatory_meet_1'];
            $consultant_report->sum_single_meet_1 +=$ConsultantReport['sum_single_meet_1'];
            $consultant_report->sum_remote_1 +=$ConsultantReport['sum_remote_1'];


            $consultant_report->sum_financial_manager_status_approved +=$ConsultantReport['sum_financial_manager_status_approved'];
            $consultant_report->sum_financial_manager_status_pending +=$ConsultantReport['sum_financial_manager_status_pending'];
            $consultant_report->sum_financial_financial_status_approved +=$ConsultantReport['sum_financial_financial_status_approved'];
            $consultant_report->sum_financial_financial_status_pending +=$ConsultantReport['sum_financial_financial_status_pending'];
            $consultant_report->sum_financial_financial_status_semi_approved +=$ConsultantReport['sum_financial_financial_status_semi_approved'];
            $consultant_report->sum_financial_student_status_ok +=$ConsultantReport['sum_financial_student_status_ok'];
            $consultant_report->sum_financial_student_status_refused +=$ConsultantReport['sum_financial_student_status_refused'];
            $consultant_report->sum_financial_student_status_fired +=$ConsultantReport['sum_financial_student_status_fired'];

            $consultant_report->sum_financial_student_status_financial_pending +=$ConsultantReport['sum_financial_student_status_financial_pending'];
            $consultant_report->sum_financial_student_status_fire_pending +=$ConsultantReport['sum_financial_student_status_fire_pending'];
            $consultant_report->sum_financial_student_status_refuse_pending +=$ConsultantReport['sum_financial_student_status_refuse_pending'];
            $consultant_report->sum_financial_financial_refused_status_not_returned +=$ConsultantReport['sum_financial_financial_refused_status_not_returned'];
            $consultant_report->sum_financial_financial_refused_status_returned +=$ConsultantReport['sum_financial_financial_refused_status_returned'];
            $consultant_report->sum_financial_financial_refused_status_noMoney +=$ConsultantReport['sum_financial_financial_refused_status_noMoney'];

        }

            return $consultant_report;
        }
        return ConsultantReport::where('deleted_at', null)
            ->where('id', -1);
    }
}
