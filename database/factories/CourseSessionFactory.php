<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                "user_id"    =>User::factory(),
                "course_id"  =>Course::factory(),
                "name"       =>$this->facker->name(),
                "start_date" =>$this->faker->data("Y-m-d"),
                "start_time" =>Carbon::parse(now())->format('H:00:00'),
                "end_time"  =>Carbon::parse(now('+5 Hour'))->format('H:00:00')                
        ];
    }
}
