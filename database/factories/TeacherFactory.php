<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TeacherFactory extends Factory
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
        return [
                    "first_name" => $this->faker->firstName(),
                    "last_name" => $this->faker->lastName(),
                    "mobile" => $this->faker->regexify('09[0-9]{9}'),//"09".$this->faker->rand(0000000,9999999),
                    "address" => $this->faker->address(),
                    "user_id" => $user
            
        ];
    }
}
