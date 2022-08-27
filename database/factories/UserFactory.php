<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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
            'user_id_creator' => 1,
            'group_id' =>$this->faker->numberBetween(1,5),
            'branch_id' => Branch::factory(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('12345678'),//'$2a$12$F/R.dG7Dwt1YYyeQU/HLdury4272cGbZl8A.25xVPOerlAo8QG5Wa', // password 12345

            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
           // 'mobile' =>  $this->faker->regexify('09[0-9]{9}'),//$this->faker->phoneNumber,//$this->faker->,
            //'email_verified_at' => now(),
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
