<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\StudentWarningHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentWarning>
 */
class StudentWarningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        $course=$this->faker->randomElement(Course::pluck('id'));
        if($course===null)
        {
            $course=Course::factory()->create();
            $course=$course->id;
        }
        $student_warning_history=$this->faker->randomElement(StudentWarningHistory::pluck('id'));
        if($student_warning_history===null){
            $student_warning_history=StudentWarningHistory::factory()->create();
            $student_warning_history=$student_warning_history->id;
        }
        
        return [
            "user_id_creator" =>$user,
            "user_id_updator" => 0,
            "student_id" => rand(100,200),
            "course_id" => $course,
            "comment" => $this->faker->text(),
            "student_warning_history_id" => $student_warning_history,

        ];
    }
}
