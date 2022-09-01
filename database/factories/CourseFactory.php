<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Year;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lesson=['Mathematics','Physics','Biology'];
        $type=["private","public"];
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        
        $year=$this->faker->randomElement(Year::pluck('id'));// User::factory()->create();
        if($year===null)
        {
            $year= Year::factory()->create();
            $year=$year->id;
        }

        return [
            "user_id_creator" => $user,
            "branch_id" => Branch::factory(),
            "gender" => $this->faker->randomElement(["male", "female"]),
            "year_id" => $year,
            "teacher_id" => User::factory()->create(["group_id" =>5]), // this is teacher
            "name" => $this->faker->randomElement(["فیزیک","ریاضی","شیمی"]),
            "lesson_id" => Lesson::factory(),
            "education_level" => rand(1,14),
            "type" => $this->faker->randomElement(["public","private","semi-private","master"]),
            "financial_status" => $this->faker->randomElement(["approved","pending"]),           
            "user_id_financial" => User::factory()->create(["group_id" => 3]),    // this is financial user         
            //"type" => $type[rand(0,1)]
            //
        ];
    }
}
