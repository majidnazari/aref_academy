<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseSession;


class AzmoonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {       
        $user=$this->faker->randomElement(User::pluck('id'));
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        $course=$this->faker->randomElement(Course::pluck('id'));
        if($course===null)
        {
            $course= Course::factory()->create();
            $course=$course->id;
        }
        $course_session=$this->faker->randomElement(CourseSession::pluck('id'));
        if($course_session===null)
        {
            $course_session= CourseSession::factory()->create();
            $course_session=$course_session->id;
        }
        
        $isSMSsend= $this->faker->boolean;
        $score=$this->faker->randomFloat(2, 10, 100);
        return [
            "user_id" => $user,
            "course_id" => $course,
            "course_session_id" => $course_session,
            "isSMSsend" => $isSMSsend,
            "score" => $score,            
            //
        ];
    }
}
