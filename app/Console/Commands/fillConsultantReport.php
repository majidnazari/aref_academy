<?php

namespace App\Console\Commands;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use App\Models\ConsultantReport;
use App\Models\StudentInfo;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class fillConsultantReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:consultantReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activeYearId = Year::orderBy('active', 'desc')
        ->orderBy('name', 'desc')
        ->value('id');    
        
        //Log::info(Carbon::createFromFormat('H:i', "23:30")->diffInMinutes(Carbon::createFromFormat('H:i', "22:10")) ) ;
  
        $consultantFinancials=ConsultantFinancial::orderBy('created_at','asc')->get();
        foreach($consultantFinancials as $consultantFinancial)
        {
            $consultantReportExist=ConsultantReport::where('statical_date',$consultantFinancial['created_at']->format('Y-m-d'))
            ->where('consultant_id',$consultantFinancial['consultant_id'])
            ->first();

            $studentinfo=StudentInfo::where('student_id',$consultantFinancial['student_id'])->first();
           
            //Log::info("student id  is:".$consultantFinancial['student_id'] . " and student is:".json_encode( $studentinfo));
            //Log::info("date is:".$consultantFinancial['created_at']->format('Y-m-d'));
            if($consultantReportExist)
            {
                //$consultantReportExist['consultant_id']=$consultantFinancial['consultant_id'];
                $consultantReportExist['sum_students_registered'] +=1;
               
                isset($studentinfo['major']) 
                ? $consultantReportExist['sum_students_major_'.$studentinfo['major']] +=1 
                : null;

                isset($studentinfo['education_level']) 
                ? $consultantReportExist['sum_students_education_level_'.$studentinfo['education_level']] +=1 
                : null;

                isset($consultantFinancial['manager_status']) 
                ? $consultantReportExist['sum_financial_manager_status_'.$consultantFinancial['manager_status']] +=1 
                : null;

                isset($consultantFinancial['financial_status']) 
                ? $consultantReportExist['sum_financial_financial_status_'.$consultantFinancial['financial_status']] +=1 
                : null;

                isset($consultantFinancial['student_status']) 
                ? $consultantReportExist['sum_financial_student_status_'.$consultantFinancial['student_status']] +=1 
                : null;

                isset($consultantFinancial['financial_refused_status']) 
                ? $consultantReportExist['sum_financial_financial_refused_status_'.$consultantFinancial['financial_refused_status']] +=1 
                : null;


            }
            else{
                $consultantReportExist = new ConsultantReport();
                $consultantReportExist->consultant_id=$consultantFinancial['consultant_id'];
                $consultantReportExist->year_id=$activeYearId;
                $consultantReportExist->statical_date=$consultantFinancial['created_at']->format('Y-m-d');
                $consultantReportExist->sum_students_registered +=1;
                
                if(isset($studentinfo['major'])){
                    $major="sum_students_major_".$studentinfo['major'];
                    $consultantReportExist->$major +=1 ;
                } 
                if(isset($studentinfo['education_level'])){
                    $level="sum_students_education_level_".$studentinfo['education_level'];
                    $consultantReportExist->$level +=1 ;
                } 
                if(isset($consultantFinancial['manager_status'])){
                    $manager_status="sum_financial_manager_status_".$consultantFinancial['manager_status'];
                    //Log::info("manager status is:" .$manager_status . " and total is: " .$consultantReportExist->$manager_status);
                    $consultantReportExist->$manager_status +=1 ;
                } 
                if(isset($consultantFinancial['financial_status'])){
                    $financial_status="sum_financial_financial_status_".$consultantFinancial['financial_status'];
                    $consultantReportExist->$financial_status +=1 ;
                } 
                if(isset($consultantFinancial['student_status'])){
                    $student_status="sum_financial_student_status_".$consultantFinancial['student_status'];
                    $consultantReportExist->$student_status +=1 ;
                } 
                if(isset($consultantFinancial['financial_refused_status'])){
                    $student_status="sum_financial_financial_refused_status_".$consultantFinancial['financial_refused_status'];
                    $consultantReportExist->$student_status +=1 ;
                } 


            }
            $consultantReportExist->save();

        }

        $consultantDefinitionDetails=ConsultantDefinitionDetail::orderBy('session_date','asc')->get();
        foreach($consultantDefinitionDetails as $consultantDefinitionDetail)
        {
            $consultantReportExist=ConsultantReport::where('statical_date',$consultantDefinitionDetail['session_date'])
            ->where('consultant_id',$consultantDefinitionDetail['consultant_id'])
            ->first();

            if($consultantReportExist)
            {
                $consultantReportExist['sum_is_defined_consultant_session'] +=1 ;
                $consultantReportExist['sum_is_defined_consultant_session_in_minutes'] +=
                Carbon::createFromFormat('H:i', $consultantDefinitionDetail['end_hour'])->diffInMinutes(Carbon::createFromFormat('H:i', $consultantDefinitionDetail['start_hour']));
                
                if(isset($consultantDefinitionDetail['student_id']))
                {
                    $consultantReportExist['sum_is_filled_consultant_session'] +=1 ;
                    $consultantReportExist['sum_is_filled_consultant_session_in_minutes'] +=
                    Carbon::createFromFormat('H:i', $consultantDefinitionDetail['end_hour'])->diffInMinutes(Carbon::createFromFormat('H:i', $consultantDefinitionDetail['start_hour']));
                    //Carbon::parse($consultantDefinitionDetail['end_hour'])->format("H:i") - Carbon::parse($consultantDefinitionDetail['start_hour'])->format("H:i") ;
                } 

                isset($consultantDefinitionDetail['student_status']) 
                ? $consultantReportExist['sum_student_status_'.$consultantDefinitionDetail['student_status']] +=1 
                : null; 

                isset($consultantDefinitionDetail['session_status']) 
                ? $consultantReportExist['sum_session_status_'.$consultantDefinitionDetail['session_status']] +=1 
                : null;

                isset($consultantDefinitionDetail['consultant_status']) 
                ? $consultantReportExist['sum_consultant_status_'.$consultantDefinitionDetail['consultant_status']] +=1 
                : null;


                ($consultantDefinitionDetail['compensatory_meet'] ) 
                ? $consultantReportExist['sum_compensatory_meet_1'] +=1 
                : null;

                ($consultantDefinitionDetail['single_meet'] ) 
                ? $consultantReportExist['sum_single_meet_1'] +=1 
                : null;

                ($consultantDefinitionDetail['remote'] ) 
                ? $consultantReportExist['sum_remote_1'] +=1 
                : null;
            }
            else{
                $consultantReportExist = new ConsultantReport();
                $consultantReportExist->consultant_id=$consultantDefinitionDetail['consultant_id'];
                $consultantReportExist->year_id=$activeYearId; 
                $consultantReportExist->statical_date=$consultantDefinitionDetail['session_date'];


                $consultantReportExist->sum_is_defined_consultant_session +=1 ;
                $consultantReportExist->sum_is_defined_consultant_session_in_minutes+=
                Carbon::createFromFormat('H:i', $consultantDefinitionDetail['end_hour'])->diffInMinutes(Carbon::createFromFormat('H:i', $consultantDefinitionDetail['start_hour']));
                             

                if(isset($consultantDefinitionDetail['student_id']))
                {
                    $consultantReportExist->sum_is_filled_consultant_session +=1 ;
                    $consultantReportExist->sum_is_filled_consultant_session_in_minutes+=
                    Carbon::createFromFormat('H:i', $consultantDefinitionDetail['end_hour'])->diffInMinutes(Carbon::createFromFormat('H:i', $consultantDefinitionDetail['start_hour']));
                    //Carbon::parse($consultantDefinitionDetail['end_hour'])->format("H:i") - Carbon::parse($consultantDefinitionDetail['start_hour'])->format("H:i") ;
                }  
            
                if(isset($consultantDefinitionDetail['student_status'])){
                    $student_status="sum_student_status_".$consultantDefinitionDetail['student_status'];
                    $consultantReportExist->$student_status +=1 ;
                }
                if(isset($consultantDefinitionDetail['session_status'])){
                    $session_status="sum_session_status_".$consultantDefinitionDetail['session_status'];
                    $consultantReportExist->$session_status +=1 ;
                } 
                if(isset($consultantDefinitionDetail['consultant_status'])){
                    $consultant_status="sum_consultant_status_".$consultantDefinitionDetail['consultant_status'];
                    $consultantReportExist->$consultant_status +=1 ;
                } 
                if($consultantDefinitionDetail['compensatory_meet']){
                    
                    $consultantReportExist->sum_compensatory_meet_1 +=1 ;
                } 
                if($consultantDefinitionDetail['single_meet']){
                    
                    $consultantReportExist->sum_single_meet_1 +=1 ;
                } 

                if($consultantDefinitionDetail['remote']){
                    
                    $consultantReportExist->sum_remote_1 +=1 ;
                }               

            }
            $consultantReportExist->save();
        }
        //return Command::SUCCESS;
    }
}
