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
    public function test_CourseFetchAll()
    {  
        $course=self::CourseData();
        $response_create = $this->post(route('Course.store'),$course);         
        $response_getAll = $this->get(route('Course.index')); 
       // dd($response_create);
       
       $response_getAll->assertSee($course["name"]);
       $response_getAll->assertSee($course["user_id"]);
       $response_getAll->assertSee($course["year_id"]);
       $response_getAll->assertSee($course["teacher_id"]);
       $response_getAll->assertSee($course["lesson"]);
       $response_getAll->assertSee($course["type"]);    
    }
    public function test_CourseStore()
    {
        $course=self::CourseData();
      // dd($course["mobile"]);
        $response = $this->post(route('Course.store'), $course );  
       // dd($response["id"]);    
        //$courses = Course::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Course::all()->count());        
       // $this->assertDatabaseCount('courses', 1);
       $this->assertDatabaseHas('courses', [
        'name' => $course["name"],
        'type' => $course["type"],
        'lesson' => $course["lesson"],
        'users_id' => $course["user_id"],
        'years_id' => $course["year_id"],
        'teachers_id' => $course["teacher_id"],
        ]);
        $course_response = Course::where('name', $course["name"])
        ->where('type', $course["type"])
        ->where('lesson', $course["lesson"])
        ->where('years_id', $course["year_id"])
        ->where('teachers_id', $course["teacher_id"])
        ->where('users_id', $course["user_id"])
        ->first();
         $this->assertNotNull($course_response);        
    }
    public function test_CourseUpdate()
    {           
        $newCourse=self::CourseData();
        $responseCreate = $this->post(route('Course.store'), $newCourse );
        $anotherCourse=self::CourseData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('Course.update', $responseCreate['id']),$anotherCourse); 
        $courseFounded = Course::where('name', $anotherCourse["name"])
        ->where('type', $anotherCourse["type"])
        ->where('lesson', $anotherCourse["lesson"])
        ->where('years_id', $anotherCourse["year_id"])
        ->where('teachers_id', $anotherCourse["teacher_id"])
        ->where('users_id', $anotherCourse["user_id"])
        ->first();
       // dd($anotherCourse,$courseFounded);
        $this->assertNotNull($courseFounded);
        // $this->assertAuthenticatedAs($course);
    }
    public function test_CourseDelete()
    { 
        $course=self::CourseData(); 
        $response = $this->post(route('Course.store'), $course );          
        $responseDelete = $this->delete(route('Course.destroy', $response["id"]));        
        $CourseFound= Course::withTrashed()->find($response["id"]);  
       //dd($CourseFound);
        $this->assertSoftDeleted($CourseFound);      
    }
    public  function  CourseData()
    {        
        $name= $this->faker->name();
        $user_id= $this->faker->randomNumber();
        $years_id= $this->faker->randomNumber();
        $teachers_id=$this->faker->randomNumber();
        // $type=new Sequence(['public','private']);
        // $lesson= new Sequence(['Mathematics','Physics','Biology']);
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
