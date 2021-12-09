<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                    "user_id"     =>User::factory(),
                    "name"        =>$this->faker()->name(),
                    "description" =>$this->faker()->text(),
        ];
    }
}
