<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AzmoonResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        // if($user===null)
        // {
        //     $user= User::factory()->create();
        //     $user=$user->id;
        // }
        return [
                    "student_id"=>$this->faker->random(0,100),
                    "result_score" => $this->faker->random(0,100)            
               ];
    }
}
