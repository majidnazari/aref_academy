<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Course;

class CourseStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //dd("course session is run");
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        //dd( $user);
        $course=Course::factory()->create();
        //dd($course->id);
        $student=$this->faker->randomDigit;
        $status=$this->faker->randomElement(['approved','pending']);              
      
        //dd( $user);
        
       return  [
                    "course_id"  => $course,
                    "student_id" => $student,
                    "status"     => $status,
                    "user_id_created" =>$user,
                    "user_id_approved" =>$user,
                ];
    }
}
