<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\StudentContact;
use App\Models\AbsencePresence;
use Carbon\Carbon;

class StudentContactFactory extends Factory
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
        $absencepresence_id=$this->faker->randomDigit;
      
        $who_answered=$this->faker->randomElement(["father","mother","other"]);
        $description=$this->faker->text;
        $is_called_successfull=$this->faker->randomElement([false,true]);
       
        return  [
            'user_id' => $user,			
			'student_id' => $student_id,			
			'absence_presence_id' => $absencepresence_id,			
			'who_answered' => $who_answered,			
			'description' => $description,			
			'is_called_successfull' => $is_called_successfull,	
        ];
    }
}
