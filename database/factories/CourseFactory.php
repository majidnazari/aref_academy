<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            "user_id" => User::factory(),
            "year_id" => Year::factory(),
            "teacher_id" => $this->faker->randomDigit,
            "name" => $this->faker->name(),
            "lesson" => $this->faker->randomElement(['Mathematics','Physics','Biology']),
            "type" => $type[rand(0,2)]
            //
        ];
    }
}
