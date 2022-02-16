<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Group;
use App\Models\AbsencePresence;
use Carbon\Carbon;

class GroupFactory extends Factory
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
        
        $name=$this->faker->unique()->randomElement(["admin","user","readonly"]); 
        return  [
            
            'user_id' => $user,			
			'name' => $name	
        ];
    }
}
