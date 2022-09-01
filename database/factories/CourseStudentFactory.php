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
       
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }

        $user_manager=$this->faker->randomElement(User::where('group_id',2)->pluck('id'));// fetch user with manager role
        if($user_manager===null)
        {
            $user_manager= User::factory()->create(['group_id' => 2]);
            $user_manager=$user_manager->id;
        }

        $user_financial=$this->faker->randomElement(User::where('group_id',3)->pluck('id'));// fetch user with finantial role
        if($user_financial===null)
        {
            $user_financial= User::factory()->create(['group_id' => 3]);
            $user_financial=$user_financial->id;
        }

        $user_student_status=$this->faker->randomElement(User::where('group_id',4)->pluck('id'));// fetch user with acceptor role
        if($user_student_status===null)
        {
            $user_student_status= User::factory()->create(['group_id' => 4]);
            $user_student_status=$user_student_status->id;
        }

       
        $course=Course::factory()->create();
        
        $student=$this->faker->randomDigit;
        $status=$this->faker->randomElement(['approved','pending']);              
        $financial_status=$this->faker->randomElement(['approved','pending','semi_approved']);              
        $student_status=$this->faker->randomElement(['ok','refused','fired','financial_pending','forbidden','fired_pending','refused_pending']);              
      
       return  [
                    "user_id_creator" => $user,
                    "course_id"  => $course,
                    "student_id" => $student,
                    "manager_status"     => $status,
                    "financial_status"     => $financial_status,
                    "student_status"     => $student_status,

                    "user_id_manager" =>$user_manager,
                    "user_id_financial" =>$user_financial,
                    "user_id_student_status" =>$user_student_status,
                    
                ];
    }
}
