<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CourseStudent;

class CourseStudentTest extends TestCase
{       
        use WithFaker;
       // use RefreshDatabase;
        /**
         * A basic feature test example.
         *
         * @return void
         */
        public function test_CourseStudentFetchAll()
        {  
            //$coursestudent=self::coursestudentData(); 
            $coursestudent=CourseStudent::factory()->make();
            //dd($coursestudent->toArray());      
            $response_create = $this->post(route('CourseStudent.store'),$coursestudent->toArray());
            //dd($response_create->decodeResponseJson());         
            $response_getAll = $this->get(route('CourseStudent.index')); 
            //dd($response_getAll->decodeResponseJson());
            //dd($response_create);
           
           $response_getAll->assertSee($coursestudent["course_id"]);
           $response_getAll->assertSee($coursestudent["student_id"]);
           $response_getAll->assertSee($coursestudent["status"]);
           $response_getAll->assertSee($coursestudent["user_id_created"]);
           $response_getAll->assertSee($coursestudent["user_id_approved"]);
       
        }
        public function test_CourseStudentStore()
        {
            //dd("sdfsdF");        
            $coursestudent=CourseStudent::factory()->make();
            //$coursestudent=self::coursestudentData();
            //dd($coursestudent->toArray());
            $response = $this->post(route('CourseStudent.store'), $coursestudent->toArray());  
            //dd($response->decodeResponseJson());    
            //$coursestudents = CourseStudent::factory()->count(3)->make();       
            $this->assertGreaterThan(0,CourseStudent::all()->count());        
           // $this->assertDatabaseCount('coursestudents', 1);
           $this->assertDatabaseHas('course_students', [            
            'course_id' => $coursestudent["course_id"],
            'student_id' => $coursestudent["student_id"],
            'status' => $coursestudent["status"],              
            'user_id_created' => $coursestudent["user_id_created"], 
            'user_id_approved' => $coursestudent["user_id_approved"], 
           
            ]);           
        }
        public function test_CourseStudentUpdate()
        {           
            //$newCourseStudent=self::coursestudentData();
            $coursestudent=CourseStudent::factory()->make();
            $responseCreate = $this->post(route('CourseStudent.store'), $coursestudent->toArray());
            //dd($responseCreate->decodeResponseJson());       
            $anotherCourseStudent=self::coursestudentData();
           // $email= $this->faker->unique()->safeEmail();
            //$mobile=$this->faker->regexify('09[0-9]{9}');
            //dd($responseCreate['id']);
    
            $responseUpdate = $this->put(route('CourseStudent.update', $responseCreate['id']),$anotherCourseStudent); 
           // dd($responseUpdate->decodeResponseJson());
            $coursestudentFounded = CourseStudent::
            where('student_id', $anotherCourseStudent["student_id"])
            ->where('course_id', $anotherCourseStudent["course_id"])
            ->where('status', $anotherCourseStudent["status"])
            ->where('user_id_created', $anotherCourseStudent["user_id_created"])
            ->where('user_id_approved', $anotherCourseStudent["user_id_approved"])
            //->where('user_id', $anotherCourseStudent["user_id"])
            ->first();
            //dd($coursestudentFounded);
           // dd($anotherCourseStudent,$coursestudentFounded);
            $this->assertNotNull($coursestudentFounded);
            // $this->assertAuthenticatedAs($coursestudent);
        }
        public function test_CourseStudentDelete()
        { 
            //$coursestudent=self::coursestudentData();
            $coursestudent=CourseStudent::factory()->make(); 
            $response = $this->post(route('CourseStudent.store'), $coursestudent->toArray() );          
            $responseDelete = $this->delete(route('CourseStudent.destroy', $response["id"]));        
            $CourseStudentFound= CourseStudent::withTrashed()->find($response["id"]);  
           //dd($CourseStudentFound);
            $this->assertSoftDeleted($CourseStudentFound);      
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
