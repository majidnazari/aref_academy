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
    public function test_CourseSessionFetchAll()
    {  
        $coursesession=self::CourseSessionData(); 
        //dd($coursesession);      
        $response_create = $this->post(route('CourseSession.store'),$coursesession);         
        $response_getAll = $this->get(route('CourseSession.index')); 
        //dd($response_create);
       
       $response_getAll->assertSee($coursesession["name"]);
       $response_getAll->assertSee($coursesession["user_id"]);
       $response_getAll->assertSee($coursesession["course_id"]);
       $response_getAll->assertSee($coursesession["start_date"]);
       $response_getAll->assertSee($coursesession["start_time"]);
       $response_getAll->assertSee($coursesession["end_time"]);    
    }
    public function test_CourseSessionStore()
    {
        $coursesession=self::CourseSessionData();
      // dd($coursesession["mobile"]);
        $response = $this->post(route('CourseSession.store'), $coursesession );  
       // dd($response["id"]);    
        //$coursesessions = CourseSession::factory()->count(3)->make();       
        $this->assertGreaterThan(0,CourseSession::all()->count());        
       // $this->assertDatabaseCount('coursesessions', 1);
       $this->assertDatabaseHas('course_sessions', [
        'name' => $coursesession["name"],
        'users_id' => $coursesession["user_id"],
        'courses_id' => $coursesession["course_id"],
        'start_date' => $coursesession["start_date"],
        'start_time' => $coursesession["start_time"],
        'end_time' => $coursesession["end_time"],
        ]);
        // $coursesession_response = CourseSession::
        // where('name', $coursesession["name"])
        // ->where('courses_id', $coursesession["courses_id"])
        // ->where('start_date', $coursesession["start_date"])
        // ->where('start_time', $coursesession["start_time"])
        // ->where('end_time', $coursesession["end_time"])
        // ->where('users_id', $coursesession["users_id"])
        // ->first();
        //  $this->assertNotNull($coursesession_response);        
    }
    public function test_CourseSessionUpdate()
    {           
        $newCourseSession=self::CourseSessionData();
        $responseCreate = $this->post(route('CourseSession.store'), $newCourseSession );
        $anotherCourseSession=self::CourseSessionData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        //dd($anotherCourseSession);

        $responseUpdate = $this->put(route('CourseSession.update', $responseCreate['id']),$anotherCourseSession); 
        //dd($anotherCourseSession,$responseUpdate);
        $coursesessionFounded = CourseSession::
        where('name', $anotherCourseSession["name"])
        ->where('courses_id', $anotherCourseSession["course_id"])
        ->where('start_date', $anotherCourseSession["start_date"])
        ->where('start_time', $anotherCourseSession["start_time"])
        ->where('end_time', $anotherCourseSession["end_time"])
        ->where('users_id', $anotherCourseSession["user_id"])
        ->first();
        //dd($coursesessionFounded);
       // dd($anotherCourseSession,$coursesessionFounded);
        $this->assertNotNull($coursesessionFounded);
        // $this->assertAuthenticatedAs($coursesession);
    }
    public function test_CourseSessionDelete()
    { 
        $coursesession=self::CourseSessionData(); 
        $response = $this->post(route('CourseSession.store'), $coursesession );          
        $responseDelete = $this->delete(route('CourseSession.destroy', $response["id"]));        
        $CourseSessionFound= CourseSession::withTrashed()->find($response["id"]);  
       //dd($CourseSessionFound);
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
			'name' => $this->faker->randomElement(["فیزیک","ریاضی","شیمی"]),//new sequence(["فیزیک","ریاضی","شیمی"]),
			'from_date' => Carbon::parse(now())->format('Y-m-d') ,
			'to_date' => Carbon::parse(now()->addMonths(1))->format('Y-m-d'),
			'from_time' => Carbon::parse(now())->format('H:00:00'),			
			'to_time' => Carbon::parse(now('+5 Hour'))->format('H:00:00'),
			//'course' => $request->course,			
		   ];
           //dd($data);
           $response = $this->post(route('CourseSession.AddSessions'), $data );  
          //dd($response->set(json_decode((new UserResource($user))->toJson());
          $this->assertDatabaseHas('course_sessions', [
            'name' => $response["name"],
            'users_id' => $response["user_id"],
            'courses_id' => $response["course_id"],
            'start_date' => $response["start_date"],
            'start_time' => $response["start_time"],
            'end_time' => $response["end_time"],
            ]);
    }

    public  function  CourseSessionData()
    {        
        $name= $this->faker->name();
        $users_id= $this->faker->randomDigit;
        $courses_id= $this->faker->randomDigit;        
        $start_date=$this->faker->date();
        $start_time=$this->faker->time();
        //$from_time=date('H:i:s', rand($start_time*60*60,$start_time*60*60*5));       
        $end_time= $this->faker->time();
        //$end_time= date('H:i:s', rand(1,54000)); // 00:00:00 - 15:00:00
        // $type=new Sequence(['public','private']);
        // $lesson= new Sequence(['Mathematics','Physics','Biology']);
        // $typeSample=['public','private'];        
        // $lessonSample= ['Mathematics','Physics','Biology'];

        // $type=$typeSample[rand(0,1)];
        // $lesson= $lessonSample[rand(0,2)];
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
