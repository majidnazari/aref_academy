<?php

namespace App\AuthFacade;
use App\Models\User;
use Log;

class CheckAuth
{
    private $admin_group=array("admin");
    private $manager_group=array("manager");
    private $financial_group=array("financial");
    private $acceptor_group=array("acceptor");
    private $teacher_group=array("teacher"); 
    private $group_access=array(
        "AbsencePresence" => array( "admin","manager","acceptor"),
        "Lesson" =>array ( "admin","manager"),
        "Fault" => array("admin","manager"),
        "Year" =>array ("admin","manager","financial","acceptor","teacher","consultant_manager"),
        "CourseSession" =>array ("admin","manager","acceptor"),
        "Course" => array("admin","manager","financial","acceptor"),
        "CourseStudent" => array("admin","manager","financial","acceptor"),
        "Users" => array("admin","manager","acceptor","consultant_manager"), 
        "BranchClassRooms" => array("admin","manager","consultant_manager"), 
        "GetCourseStudentsWithAbsencePresence" => array("admin","manager","acceptor"), 
        //"GetCourseStudentsWithAbsencePresenceList" => array("admin","manager","acceptor"), 
        "Branches" =>array("admin","manager","financial","consultant_manager"),         
        "StudentContact" =>array("admin","manager"), 
        "StudentFault" =>array("admin","manager"), 
        "GetCourseStudentsWithIllegalStudent" =>array("admin","manager"),
        "StudentWarningHistory" => array("admin","financial"),
        "GetCourseStudentsWithAbsencePresenceList" => array("admin","manager","financial"),
        "CourseTotalReport" => array("admin","manager","financial"),
        "CourseReportAtSpecialTime" => array("admin","manager"),
        "ConsultantDefinitionDetail" => array("admin","manager","consultant_manager"),
        "ConsultantFinancial" => array("admin","financial","consultant_manager"),
        "CourseReportAtSpecialTimeSortedByDate" =>array("admin","manager","acceptor","consultant_manager"),
        "GetConsultantsTimeShow" => array("admin","manager","acceptor","consultant_manager"),
        "Consultants" => array("admin","manager","consultant_manager","financial"),
        "ConsultantDefinitionDetailReport" => array("admin","manager","consultant_manager")
        
       
    );
    
    public function CheckAccessibility(string $actionName){
        $user_role=auth()->guard('api')->user()->group->type; 
        if(in_array( $user_role,$this->group_access[$actionName])){            
            return true;
        }           
        return false;
    }   
} 