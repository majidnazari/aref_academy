<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\StudentFault;
use App\Models\Fault;
use Carbon\Carbon;

class StudentFaultFactory extends Factory
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
       
        $student_id=$this->faker->randomDigit;
        $fault_id=$this->faker->randomDigit;
            
        return  [
            'user_id_creator' => $user,	            
			'student_id' => $student_id,			
			'fault_id' => Fault::factory(),	
        ];
    }
}
