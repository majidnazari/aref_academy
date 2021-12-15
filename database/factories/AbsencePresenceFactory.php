<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\CourseSession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
//use Illuminate\Foundation\Testing\WithFaker;
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
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
       // dd($user->id);  
        $course_session= CourseSession::factory()->create();//$this->faker->randomDigit;
        //dd($course_session->id);
        $teacher_id=$this->faker->randomDigit;
        $status=['dellay','absent','present'];

        return [           
            'user_id' => $user,
            'teacher_id' => $teacher_id,
            'course_session_id' => $course_session->id,
            'status' =>$this->faker->randomElement(['dellay','absent','present'])// $status[rand(0,2)]       
        ];
    }
}
