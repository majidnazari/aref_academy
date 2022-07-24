<?php

namespace App\GraphQL\Entities;

use Log;

class Student {
    public function __invoke($rep)
    {   
        //Log::info("STUDENT : " . json_encode($rep));
        return ["__typename" => "Student", "id" => 69];
    }
}