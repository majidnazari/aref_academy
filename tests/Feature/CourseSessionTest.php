<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CourseSessionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_courseSessionFetchAll()
    {  
        //$coursesession=self::courseSessionData(); 
        $coursesession=CourseSession::factory()->make();
          
        $response_create = $this->post(route('CourseSession.store'),$coursesession->toArray());               
        $response_getAll = $this->get(route('CourseSession.index')); 
      
       
       $response_getAll->assertSee($coursesession["name"]);
       $response_getAll->assertSee($coursesession["user_id"]);
       $response_getAll->assertSee($coursesession["course_id"]);
       $response_getAll->assertSee($coursesession["start_date"]);
       $response_getAll->assertSee($coursesession["start_time"]);
       $response_getAll->assertSee($coursesession["end_time"]);    
    }
    public function test_courseSessionStore()
    {
        $coursesession=CourseSession::factory()->make();
       
        $response = $this->post(route('CourseSession.store'), $coursesession->toArray() ); 
       
        $this->assertGreaterThan(0,CourseSession::all()->count());       
     
       $this->assertDatabaseHas('course_sessions', [
        'name' => $coursesession["name"],
        'user_id' => $coursesession["user_id"],
        'course_id' => $coursesession["course_id"],
        'start_date' => $coursesession["start_date"],
        'start_time' => $coursesession["start_time"],
        'end_time' => $coursesession["end_time"],
        ]);
               
    }
    public function test_courseSessionUpdate()
    {           
        //$newCourseSession=self::courseSessionData();
        $coursesession=CourseSession::factory()->make();
        $responseCreate = $this->post(route('CourseSession.store'), $coursesession->toArray());
        $anotherCourseSession=self::courseSessionData();      

        $responseUpdate = $this->put(route('CourseSession.update', $responseCreate['id']),$anotherCourseSession); 
       
        $coursesessionFounded = CourseSession::
        where('name', $anotherCourseSession["name"])
        ->where('course_id', $anotherCourseSession["course_id"])
        ->where('start_date', $anotherCourseSession["start_date"])
        ->where('start_time', $anotherCourseSession["start_time"])
        ->where('end_time', $anotherCourseSession["end_time"])
        ->where('user_id', $anotherCourseSession["user_id"])
        ->first();
      
        $this->assertNotNull($coursesessionFounded);
       
    }
    public function test_courseSessionDelete()
    { 
        //$coursesession=self::courseSessionData();
        $coursesession=CourseSession::factory()->make(); 
        $response = $this->post(route('CourseSession.store'), $coursesession->toArray() );          
        $responseDelete = $this->delete(route('CourseSession.destroy', $response["id"]));        
        $CourseSessionFound= CourseSession::withTrashed()->find($response["id"]);  
      
        $this->assertSoftDeleted($CourseSessionFound);      
    }

    public function test_CourseSessionAddListOfDays()
    {
        $days=[
            "Saturday",
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday"
        ];

        $data=[
            'user_id' => $this->faker->randomDigit,
			'course_id' => $this->faker->randomDigit,
            'days' => [$days[rand(0,3)],$days[rand(4,6)]],
			'name' => $this->faker->randomElement(["??????????","??????????","????????"]),//new sequence(["??????????","??????????","????????"]),
			'from_date' => Carbon::parse(now())->format('Y-m-d') ,
			'to_date' => Carbon::parse(now()->addMonths(1))->format('Y-m-d'),
			'from_time' => Carbon::parse(now())->format('H:00:00'),			
			'to_time' => Carbon::parse(now('+5 Hour'))->format('H:00:00'),
			//'course' => $request->course,			
		   ];
         
           $response = $this->post(route('CourseSession.AddSessions'), $data ); 

          $this->assertDatabaseHas('course_sessions', [
            'name' => $response["name"],
            'user_id' => $response["user_id"],
            'course_id' => $response["course_id"],
            'start_date' => $response["start_date"],
            'start_time' => $response["start_time"],
            'end_time' => $response["end_time"],
            ]);
    }

    public  function  courseSessionData()
    {        
        $name= $this->faker->name();
        $users_id= $this->faker->randomDigit;
        $courses_id= $this->faker->randomDigit;        
        $start_date=$this->faker->date();
        $start_time=$this->faker->time();
        //$from_time=date('H:i:s', rand($start_time*60*60,$start_time*60*60*5));       
        $end_time= $this->faker->time();
      
        $coursesession=[
            'user_id' => $users_id,
            'course_id' => $courses_id,
            'start_date' => $start_date,
            'start_time' => $start_time,              
            'end_time' => $end_time,              
            'name' => $name,              
        ];
        return $coursesession;
    }
}
