<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class GateFactory extends Factory
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
                   
                    "user_id"     => $user,
                    "name"        =>$this->faker->unique()->randomElement(["student","year","fault","azmoon","studentContact"]),
                    "description" =>$this->faker->text(),
        ];
    }
}
