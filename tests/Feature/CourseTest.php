<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class CourseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_getOneCourse()
    // {       
    //     $Course_model = Course::factory()->make()->toArray();
    //     Course::create($Course_model);            

    //     $this->assertDatabaseHas('courses', $Course_model);
        
    // }
    public function test_getAllCourses()
    {
        $count=rand(2,4);
        $Course_created = Course::factory($count)->create();
      
        $this->assertGreaterThanOrEqual($count,Course::all()->count());

    }
    public function test_createCourse()
    {       
        $Course=Course::factory()->make()->toArray();
        Course::create($Course);
        $this->assertDatabaseHas('courses',$Course);             
    }
    public function test_updateCourse()
    {  
        $Course=Course::factory()->make()->toArray();
        Course::create($Course);
        $new_Course=Course::factory()->make()->toArray();
        $find_Course=Course::where($Course)->update($new_Course);
        //dd($find_Course->id);
        
        //$find_Course->update($new_Course);
        $this->assertDatabaseHas('courses',$new_Course);        
    }
    public function test_deleteCourse()
    { 
        $Course=Course::factory()->make()->toArray();
        $find_Course= Course::create($Course);
        Course::where($Course)->delete();
        // if($find_Course)
        // {
        //     $find_Course->delete();
        // }
        $CourseFound= Course::withTrashed()->find($find_Course->id);
        $this->assertSoftDeleted($CourseFound); 
     
    }
    public  function  CourseData()
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
