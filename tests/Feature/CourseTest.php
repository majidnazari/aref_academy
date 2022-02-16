<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class CourseTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_courseFetchAll()
    {  
       // $course=self::courseData();
        $course=Course::factory()->make();
       
        $response_create = $this->post(route('Course.store'),$course->toArray());         
        $response_getAll = $this->get(route('Course.index'));        
       $response_getAll->assertSee($course["name"]);
       $response_getAll->assertSee($course["user_id"]);
       $response_getAll->assertSee($course["year_id"]);
       $response_getAll->assertSee($course["teacher_id"]);
       $response_getAll->assertSee($course["lesson"]);
       $response_getAll->assertSee($course["type"]);    
    }
    public function test_courseStore()
    {
        $course=Course::factory()->make();       
        $response = $this->post(route('Course.store'), $course->toArray());              
        $this->assertGreaterThan(0,Course::all()->count());       
       
       $this->assertDatabaseHas('courses', [
        'name' => $course["name"],
        'type' => $course["type"],
        'lesson' => $course["lesson"],
        'user_id' => $course["user_id"],
        'year_id' => $course["year_id"],
        'teacher_id' => $course["teacher_id"],
        ]);
        $course_response = Course::where('name', $course["name"])
        ->where('type', $course["type"])
        ->where('lesson', $course["lesson"])
        ->where('year_id', $course["year_id"])
        ->where('teacher_id', $course["teacher_id"])
        ->where('user_id', $course["user_id"])
        ->first();
         $this->assertNotNull($course_response);        
    }
    public function test_courseUpdate()
    {     
        $course=Course::factory()->make();      
        //$newCourse=self::courseData();
        $responseCreate = $this->post(route('Course.store'), $course->toArray() );
        $anotherCourse=self::courseData();
     
        $responseUpdate = $this->put(route('Course.update', $responseCreate['id']),$anotherCourse); 
        $courseFounded = Course::where('name', $anotherCourse["name"])
        ->where('type', $anotherCourse["type"])
        ->where('lesson', $anotherCourse["lesson"])
        ->where('year_id', $anotherCourse["year_id"])
        ->where('teacher_id', $anotherCourse["teacher_id"])
        ->where('user_id', $anotherCourse["user_id"])
        ->first();
      
        $this->assertNotNull($courseFounded);
       
    }
    public function test_courseDelete()
    { 
        $course=Course::factory()->make();
        //$course=self::courseData(); 
        $response = $this->post(route('Course.store'), $course->toArray() );          
        $responseDelete = $this->delete(route('Course.destroy', $response["id"]));        
        $CourseFound= Course::withTrashed()->find($response["id"]);  
      
        $this->assertSoftDeleted($CourseFound);      
    }
    public  function  courseData()
    {        
        $name= $this->faker->name();
        $user_id= $this->faker->randomDigit;
        $years_id= $this->faker->randomDigit;
        $teachers_id=$this->faker->randomDigit;
       
        $typeSample=['public','private'];        
        $lessonSample= ['Mathematics','Physics','Biology'];

        $type=$typeSample[rand(0,1)];
        $lesson= $lessonSample[rand(0,2)];
        $course=[
            'user_id' => $user_id,
            'teacher_id' => $teachers_id,
            'year_id' => $years_id,
            'type' => $type,              
            'lesson' => $lesson,              
            'name' => $name,              
        ];
        return $course;
    }
}
