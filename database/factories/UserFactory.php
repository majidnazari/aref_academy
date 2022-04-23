<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'mobile' =>  $this->faker->regexify('09[0-9]{9}'),//$this->faker->phoneNumber,//$this->faker->,
            'type' => "admin",
            'email' => $this->faker->unique()->safeEmail(),
            //'email_verified_at' => now(),
            'password' => '$2a$12$F/R.dG7Dwt1YYyeQU/HLdury4272cGbZl8A.25xVPOerlAo8QG5Wa', // password 12345
            //'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        // return $this->state(function (array $attributes) {
        //     return [
        //         'email_verified_at' => null,
        //     ];
        // });
    }
}
