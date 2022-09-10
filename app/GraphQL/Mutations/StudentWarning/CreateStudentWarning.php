<?php

namespace App\GraphQL\Mutations\StudentWarning;

use App\Models\CreateStudentWarningHistory;
use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use GraphQL\Error\Error;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

use Log;


final class CreateStudentWarning
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {        
        $user_id=auth()->guard('api')->user()->id;
        $student_warning_params=[
            'user_id_creator' => $user_id,
            "user_id_updator" =>0,
            "student_id" =>$args['student_id'] ,
            "course_id" =>$args['course_id'] ,
            "comment" =>$args['comment'],        
           // "student_warning_history_id"=>0           
            
        ];
        $is_exist_student_warning= $this->isExist("StudentWarning",$student_warning_params);
   
        if(!$is_exist_student_warning)
        { 
            //StudentWarning::create( $student_warning_params);       
           $student_warning_created= $this->createModel('StudentWarning',$student_warning_params);
           //return $student_warning_created;
           $student_warning_history_created= $this->createModel('StudentWarningHistory',$student_warning_created);
           $student_warning_updated= $this->updateModel('StudentWarning',$params=[
                "id" => $student_warning_created->id,
                "student_warning_history_id" => $student_warning_history_created->id,
           ]);
           return  $student_warning_history_created;
        }
        
        return null;
        // $lesson=StudentWarningHistory::where("name","=",$args['name'])->first();
        // if($lesson)
        // {
        //     return Error::createLocatedError('LESSON-CREATE-RECORD_IS_EXIST');
        // }
        // $lesson_resut=Lesson::create($lesson_date);
        // return $lesson_resut;
    }

    function isExist($class,$params)
    {  
       $fullclassname='App\Models'.'\\'.$class;     
       $clause=(" where('id','>',1)");
         foreach($params as $name => $value){
             $clause.=("->where('$name' , '$value')");
            
         }
         $clause.=("->first();");
        $result= eval("return $fullclassname::$clause ;");
        if($result)
        {
            return true;
        }           
        return false;
       // Log::info("the class name is:" .  $result);
    }
    function createModel($class,$params)
    {
        $fullclassname='App\Models'.'\\'.$class;
        //Log::info("the class $fullclassname exist is : " . class_exists($fullclassname));
        if(class_exists($fullclassname))
        {
            $param_tmp="[ ";      
            foreach($params as $key=>$value)
            {
                $param_tmp.="'". $key ."'";
                $param_tmp.=" => ";
                $param_tmp.="'". $value ."'";
                $param_tmp.= " , ";               
            }
            $param_tmp.=" ]";
            $result=eval("return  $fullclassname::create($param_tmp);");
            Log::info("the create result item of " . $fullclassname ." is : " . $result);
            if($result)
            {
                return $result;
            }
            return false;
        } 
        //Log::info("the  " . $class ." DOESNOT EXIST!!." );             
        return false;
       
    }
    function updateModel($class,$params)
    {

        $fullclassname='App\Models'.'\\'.$class;
       
        if(class_exists($fullclassname))
        {
            $update_id=0;
            $param_tmp="[ ";      
            foreach($params as $key=>$value)
            {
                if($key=="id"){
                    $update_id=$value;
                    continue;
                }
                $param_tmp.="'". $key ."'";
                $param_tmp.=" => ";
                $param_tmp.="'". $value ."'";
                $param_tmp.= " , ";               
            }
            $param_tmp.=" ]";
            $result=eval("return  $fullclassname::where('id',$update_id)->update($param_tmp);");
            if($result)
            {
                return $result;
            }
            return false;
        } 
        return false;
    }
}
