<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        // if($user===null)
        // {
        //     $user= User::factory()->create(["group_id" => 1]);
        //     $user=$user->id;
        // }
        return [
            "user_id_creator" => 1,
            "name" => $this->faker->name,

        ];
    }
}
