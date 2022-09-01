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
       
        $course_session= CourseSession::factory()->create();//$this->faker->randomDigit;
        
        $teacher_id=$this->faker->randomDigit;
        $status=['dellay','absent','present'];

        return [           
            'user_id_creator' => $user,
            'teacher_id' => User::factory()->create(["group_id" => 5]),
            'course_session_id' => $course_session->id,
            'student_id' => rand(100,200),

            'status' =>$this->faker->randomElement(['absent','present','dellay15','dellay30','dellay45','dellay60','noAction']),// $status[rand(0,2)]       
            'attendance_status' => $this->faker->randomElement(['online_to_present','free_for_one','free_for_two','guest','normal']),
        ];
    }
}
