<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
//use Database\Factories\UserFactory;

class AbsencePresenceFactory extends Factory
{
    //use UserFactory;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {    
        $user=User::factory();//->create();    
        $course_session_id= $this->faker->randomDigit;
        $teacher_id=$this->faker->randomDigit;
        $status=['dellay','absent','present'];

        return [           
            'user_id' => $user,
            'teachers_id' => $teacher_id,
            'course_sessions_id' => $course_session_id,
            'status' => $status[rand(0,2)]       
        ];
    }
}
