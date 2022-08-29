<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
                    "name"    => $this->faker->unique()->numberBetween(1400,1599),//$this->faker->name(),
                    "active" => $this->faker->numberBetween(0,1), //true,//$this->faker->boolean,
        ];
    }
}
