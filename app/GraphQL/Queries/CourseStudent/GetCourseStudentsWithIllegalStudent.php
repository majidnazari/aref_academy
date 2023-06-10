<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;
use Log;

final class GetCourseStudentsWithIllegalStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    // function resolveCourseStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    // {
    //     return  [];
    //     // //Log::info("the args is:" . json_encode($args) . "\r\n and  the root value:" .json_encode($rootValue) );
    //     // $current_page=(($args['page']-1) * $args['first']);
    //     // $first_item=$args['first'];
         
    //     // if (AuthRole::CheckAccessibility("GetCourseStudentsWithIllegalStudent")) {
    //     //     // $qu = DB::table('course_students As CS')
    //     //     //     ->select(
    //     //     //         'CS.id as id',
    //     //     //         'CS.financial_status as financial_status',
    //     //     //         'AB.status as status',
    //     //     //         'CS.student_id as student_id',
    //     //     //         'Cse.name',
    //     //     //         'Cse.course_id',
    //     //     //         'AB.id as aid'
    //     //     //     )
    //     //     //     ->where('CS.financial_status', '!=', 'approved')
    //     //     //     ->leftjoin('course_sessions AS Cse', function ($query) {
    //     //     //         $query->on('Cse.course_id', 'CS.course_id');
    //     //     //     })
    //     //     //     ->join('absence_presences AS AB', function ($query) use ($args) {
    //     //     //         $query->on('AB.student_id', 'CS.student_id')
    //     //     //             ->on('AB.course_session_id', 'Cse.id')
    //     //     //             ->where('AB.status', 'present');
    //     //     //     });
    //     //     // // Log::info(json_encode($args));
    //     //     // $result = $qu->get();
    //     //     // $result = $result
    //     //     //     ->groupBy(['course_id', 'student_id']);
    //     //     // $output = collect([]);
    //     //     // foreach ($result as $courseDetails) {
    //     //     //     foreach ($courseDetails as $details) {
    //     //     //         $detail = $details[0];
    //     //     //         $detail->session_count = count($details);
    //     //     //         $output[] = $detail;
    //     //     //     }
    //     //     // }
    //     //     // $output = $output->where('session_count', '>=', 2);
    //     //     // return $output;
    //     //     $data=[];
    //     //     $query="SELECT  cs.id,c.name,cs.student_id,cs.financial_status,cs.course_id,getCoursePresents(cs.student_id,cs.course_id) as session_count
    //     //     FROM course_students cs
    //     //     left join courses as c on(c.id=cs.course_id)
    //     //     WHERE cs.financial_status!='approved' 
    //     //     AND getCoursePresents(cs.student_id,cs.course_id) > 1  limit " . $first_item  . " offset " . $current_page ;

    //     //     $count="SELECT  count(cs.id) as cnt
    //     //     FROM course_students cs            
    //     //     WHERE cs.financial_status!='approved' 
    //     //     AND getCoursePresents(cs.student_id,cs.course_id) > 1";

    //     //     $results=DB::select($query); 
    //     //     $results_count=DB::select($count); 
    //     //     return $results;

    //     //     // foreach ($results as $result)
    //     //     //     {
    //     //     //         $data["data"][] =[
    //     //     //             "id" =>  $result->id,
    //     //     //             "name" =>$result->name,
    //     //     //             "student_id" =>$result->student_id,
    //     //     //             "financial_status" =>$result->financial_status,
    //     //     //             "session_count" =>$result->session_count,
    //     //     //             "course_id" =>$result->course_id,
                       
    //     //     //         ];
                   
                    
    //     //     //     }
    //     //     //     $data["paginatorInfo"]=[
    //     //     //         "count" =>120
    //     //     //     ];
    //     //     //    // Log::info([$data]);
    //     //     // return [$data];
            
    //     //     // foreach ($results as $result)
    //     //     //     {
    //     //     //         $data["data"][] =[
    //     //     //             "id" =>  $result->id,
    //     //     //             "name" =>$result->name,
    //     //     //             "student_id" =>$result->student_id,
    //     //     //             "financial_status" =>$result->financial_status,
    //     //     //             "session_count" =>$result->session_count,
    //     //     //             "course_id" =>$result->course_id,
                       
    //     //     //         ];
                   
                    
    //     //     //     }
    //     //     //     $data["paginatorInfo"]=[
    //     //     //         "count" =>120
    //     //     //     ];
    //     //     //    // Log::info([$data]);
    //     //     // return [$data];
            
    //     // }
        
    // }
}
