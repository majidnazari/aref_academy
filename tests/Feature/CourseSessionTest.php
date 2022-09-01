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
    // public function test_getOneCourseSession()
    // {  
    //     $coursesession_new=CourseSession::factory()->make()->toArray();
    //     $coursesession=CourseSession::create($coursesession_new);
    //     $getone_courseSession=CourseSession::where($coursesession)->first();
    //     $getone_courseSession->assertsess

    //     $response_create = $this->post(route('CourseSession.store'),$coursesession->toArray());               
    //     $response_getAll = $this->get(route('CourseSession.index')); 
      
       
    //    $response_getAll->assertSee($coursesession["name"]);
    //    $response_getAll->assertSee($coursesession["user_id"]);
    //    $response_getAll->assertSee($coursesession["course_id"]);
    //    $response_getAll->assertSee($coursesession["start_date"]);
    //    $response_getAll->assertSee($coursesession["start_time"]);
    //    $response_getAll->assertSee($coursesession["end_time"]);    
    // }
    public function test_getAllCourseSession()
    {
        $count=rand(1,10);
        $coursesessions_new=CourseSession::factory($count)->create();

        $this->assertGreaterThanOrEqual($count,CourseSession::all()->count());
       // $coursesession=CourseSession::create($coursesession_new);

    }
    public function test_createCourseSession()
    {
        $coursesession=CourseSession::factory()->make()->toArray();
        CourseSession::create($coursesession);

        $this->assertDatabaseHas('course_sessions',$coursesession);
        // [
        // 'name' => $coursesession["name"],
        // 'user_id' => $coursesession["user_id"],
        // 'course_id' => $coursesession["course_id"],
        // 'start_date' => $coursesession["start_date"],
        // 'start_time' => $coursesession["start_time"],
        // 'end_time' => $coursesession["end_time"],
        // ]
               
    }
    public function test_updateCourseSession()
    {           
        //$newCourseSession=self::courseSessionData();
        $coursesession_new=CourseSession::factory()->make()->toArray();
        $coursesession=CourseSession::create($coursesession_new);

        $coursesession_update=CourseSession::factory()->make()->toArray();
        $coursesession->update($coursesession_update);

        $this->assertDatabaseHas('course_sessions',$coursesession_update);
       
    }
    public function test_courseSessionDelete()
    { 
        //$coursesession=self::courseSessionData();
        $coursesession_new=CourseSession::factory()->make()->toArray();
        $coursesession=CourseSession::create($coursesession_new);
        $coursesession->delete();
      
        $this->assertSoftDeleted($coursesession);      
    }

    // public function test_CourseSessionAddListOfDays()
    // {
    //     $days=[
    //         "Saturday",
    //         "Sunday",
    //         "Monday",
    //         "Tuesday",
    //         "Wednesday",
    //         "Thursday",
    //         "Friday"
    //     ];

    //     $data=[
    //         'user_id' => $this->faker->randomDigit,
	// 		'course_id' => $this->faker->randomDigit,
    //         'days' => [$days[rand(0,3)],$days[rand(4,6)]],
	// 		'name' => $this->faker->randomElement(["فیزیک","ریاضی","شیمی"]),//new sequence(["فیزیک","ریاضی","شیمی"]),
	// 		'from_date' => Carbon::parse(now())->format('Y-m-d') ,
	// 		'to_date' => Carbon::parse(now()->addMonths(1))->format('Y-m-d'),
	// 		'from_time' => Carbon::parse(now())->format('H:00:00'),			
	// 		'to_time' => Carbon::parse(now('+5 Hour'))->format('H:00:00'),
	// 		//'course' => $request->course,			
	// 	   ];
         
    //        $response = $this->post(route('CourseSession.AddSessions'), $data ); 

    //       $this->assertDatabaseHas('course_sessions', [
    //         'name' => $response["name"],
    //         'user_id' => $response["user_id"],
    //         'course_id' => $response["course_id"],
    //         'start_date' => $response["start_date"],
    //         'start_time' => $response["start_time"],
    //         'end_time' => $response["end_time"],
    //         ]);
    // }

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
