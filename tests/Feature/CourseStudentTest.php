<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CourseStudent;

class CourseStudentTest extends TestCase
{       
        use WithFaker;
        use RefreshDatabase;
        /**
         * A basic feature test example.
         *
         * @return void
         */
        public function test_getAllCourseStudent()
        {  
            //$coursestudent=self::coursestudentData(); 
            $count=rand(1,5);
            $coursesessions_new=CourseStudent::factory($count)->create();
    
            $this->assertGreaterThanOrEqual($count,CourseStudent::all()->count());
       
        }
        public function test_createCourseStudent()
        {
                 
            $coursestudent=CourseStudent::factory()->make()->toArray();
            CourseStudent::create($coursestudent);

            $this->assertDatabaseHas('course_students',$coursestudent);         
        }
        public function test_updateCourseStudent()
        {           
           
            $coursestudent_new=CourseStudent::factory()->make()->toArray();
            $coursestudent=CourseStudent::create($coursestudent_new);

            $coursestudent_newone=CourseStudent::factory()->make()->toArray();
            $coursestudent->update($coursestudent_newone);

            $this->assertDatabaseHas('course_students',$coursestudent_newone);            
        }
        public function test_deleteCourseStudent()
        { 
            $coursesession_new=CourseStudent::factory()->make()->toArray();
            $coursesession=CourseStudent::create($coursesession_new);
            $coursesession->delete();
        
            $this->assertSoftDeleted($coursesession);       
        }    
    
        public  function  coursestudentData()
        {   
            //$user_id= $this->faker->randomDigit;
            $course_id= $this->faker->randomDigit;        
            $student_id= $this->faker->randomDigit;        
            $status= $this->faker->randomElement(['approved','pending']);        
            $user_id_created=$this->faker->randomDigit;
            $user_id_approved=$this->faker->randomDigit;
            
            
            $coursestudent=[
                //'user_id' => $user_id,
                'course_id' => $course_id,
                'student_id' => $student_id,
                'status' => $status,
                'user_id_created' => $user_id_created,              
                'user_id_approved' => $user_id_approved,            
                            
            ];
            return $coursestudent;
        }
    
   
}
