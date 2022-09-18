<?php

namespace App\BasicFacade;

use Log;

class BasicModule
{
    public function test()
    {
        //Log::info("the create test model is run.");
        return "this is create basic method";
    }
    public  function isExist($class, $params)
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
        // Log::info("the class name is:" .  $result);
    }
    public function createModel($class, $params)
    {
        $fullclassname = 'App\Models' . '\\' . $class;
        //Log::info("the class $fullclassname exist is : " . class_exists($fullclassname));
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
            // Log::info("the create result item of " . $fullclassname . " is : " . $result);
            if ($result) {
                return $result;
            }
            return false;
        }
        //Log::info("the  " . $class ." DOESNOT EXIST!!." );             
        return false;
    }
    public function updateModel($class, $params)
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
    public function deleteModel($class, $params)
    {

        $fullclassname = 'App\Models' . '\\' . $class;

        if (class_exists($fullclassname)) {
            $deleted_id = 0;
            $param_tmp = "[ ";
            foreach ($params as $key => $value) {
                if ($key == "id") {
                    $deleted_id = $value;
                    continue;
                }
                $param_tmp .= "'" . $key . "'";
                $param_tmp .= " => ";
                $param_tmp .= "'" . $value . "'";
                $param_tmp .= " , ";
            }
            $param_tmp .= " ]";
            $result = eval("return  $fullclassname::where('id',$deleted_id)->orWhere($param_tmp)->delete();");
            if ($result) {
                return $result;
            }
            return false;
        }
        return false;
    }
}
