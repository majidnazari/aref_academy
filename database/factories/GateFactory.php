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
        $user=User::factory()->create();
        return [
                    "user_id"     => $user->id,
                    "name"        =>$this->faker->name(),
                    "description" =>$this->faker->text(),
        ];
    }
}
