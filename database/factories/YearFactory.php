<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sequence;

class YearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                    "name"    => $this->faker->randomElement(["1399","1400","1401"]),//$this->faker->name(),
                    "active" => true,//$this->faker->boolean,
        ];
    }
}
