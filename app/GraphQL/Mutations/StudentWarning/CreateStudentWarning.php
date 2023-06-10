<?php

namespace App\GraphQL\Mutations\StudentWarning;

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
        $user_id = auth()->guard('api')->user()->id;
        $student_warning_params = [
            'user_id_creator' => $user_id,           
            "student_id" => $args['student_id'],            
            "comment" => $args['comment'], 
        ];
        if(isset($args['course_id']))
        {
            $student_warning_params["course_id"]=$args['course_id'];
        }  
        $is_exist_student_warning=StudentWarning::where("student_id",$args['student_id'])->first();        

        if ($is_exist_student_warning) {
            return Error::createLocatedError('STUDENT-WARNING-RECORD_IS_EXIST');
        }
        return $this->addStudentComment($student_warning_params);       
        
    }
    function addStudentComment($student_warning_params)
    {
        $student_warning_history=StudentWarningHistory::create( $student_warning_params);
        $student_warning_params["student_warning_history_id"] = $student_warning_history->id; 
        $student_warning=StudentWarning::create( $student_warning_params); 
        return $student_warning_history;        
    }

    function isExist($class, $params)
    {
        $fullclassname = 'App\Models' . '\\' . $class;
        $clause = (" where('id','>',1)");
        foreach ($params as $name => $value) {
            $clause .= ("->where('$name' , '$value')");
        }
        $clause .= ("->first();");
        $result = eval("return $fullclassname::$clause ;");
        if ($result) {
            return $result;
        }
        return false;       
    }
    function createModel($class, $params)
    {
        $fullclassname = 'App\Models' . '\\' . $class;       
        if (class_exists($fullclassname)) {
            $param_tmp = "[ ";
            foreach ($params as $key => $value) {
                $param_tmp .= "'" . $key . "'";
                $param_tmp .= " => ";
                $param_tmp .= "'" . $value . "'";
                $param_tmp .= " , ";                
            }
        
            function isExist($class, $params)
            {
                $fullclassname = 'App\Models' . '\\' . $class;
                $clause = (" where('id','>',1)");
                foreach ($params as $name => $value) {
                    $clause .= ("->where('$name' , '$value')");
                }
                $clause .= ("->first();");
                $result = eval("return $fullclassname::$clause ;");
                if ($result) {
                    return $result;
                }
                return false;                
            }
            function createModel($class, $params)
            {
                $fullclassname = 'App\Models' . '\\' . $class;                
                if (class_exists($fullclassname)) {
                    $param_tmp = "[ ";
                    foreach ($params as $key => $value) {
                        $param_tmp .= "'" . $key . "'";
                        $param_tmp .= " => ";
                        $param_tmp .= "'" . $value . "'";
                        $param_tmp .= " , ";
                    }
                    $param_tmp .= " ]";
                    $result = eval("return  $fullclassname::create($param_tmp);");                   
                    if ($result) {
                        return $result;
                    }
                    return false;
                }                            
                return false;
            }
            function updateModel($class, $params)
            {
        
                $fullclassname = 'App\Models' . '\\' . $class;
        
                if (class_exists($fullclassname)) {
                    $update_id = 0;
                    $param_tmp = "[ ";
                    foreach ($params as $key => $value) {
                        if ($key == "id") {
                            $update_id = $value;
                            continue;
                        }
                        $param_tmp .= "'" . $key . "'";
                        $param_tmp .= " => ";
                        $param_tmp .= "'" . $value . "'";
                        $param_tmp .= " , ";
                    }
                    $param_tmp .= " ]";
            }
            $param_tmp .= " ]";
            $result = eval("return  $fullclassname::create($param_tmp);");          
            if ($result) {
                return $result;
            }
            return false;
        }                
        return false;
    }
    function updateModel($class, $params)
    {

        $fullclassname = 'App\Models' . '\\' . $class;

        if (class_exists($fullclassname)) {
            $update_id = 0;
            $param_tmp = "[ ";
            foreach ($params as $key => $value) {
                if ($key == "id") {
                    $update_id = $value;
                    continue;
                }
                $param_tmp .= "'" . $key . "'";
                $param_tmp .= " => ";
                $param_tmp .= "'" . $value . "'";
                $param_tmp .= " , ";
            }
            $param_tmp .= " ]";
            $result = eval("return  $fullclassname::where('id',$update_id)->update($param_tmp);");
            if ($result) {
                return $result;
            }
            return false;
        }
        return false;
    }
}