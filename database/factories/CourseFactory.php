<?php

namespace Database\Factories;

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
        
        $year=Year::factory()->create();
        return [
            "user_id" => $user,
            "year_id" => $year->id,
            "teacher_id" => $this->faker->randomDigit,
            "name" => $this->faker->name(),
            "lesson" => $this->faker->randomElement(['Mathematics','Physics','Biology']),
            "type" => $type[rand(0,1)]
            //
        ];
    }
}
