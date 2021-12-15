<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\AbsencePresence;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AbsencePresenceTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    //use User;
    //use Fault;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_AbsencePresenceFetchAll()
    {         
        //$data=self::AbsencePresenceData();   
        $data= AbsencePresence::factory()->make();  
        //dd($data->toArray());
        $AbsencePresenceResultStore=$this->post(route('AbsencePresence.store'),$data->toArray());
        $AbsencePresenceResultIndex=$this->get(route('AbsencePresence.index'));
        //dd($AbsencePresenceResultStore->decodeResponseJson());
        //dd("id user is: " , $data["user_id"] ," \n\r" , $AbsencePresenceResultIndex->decodeResponseJson());
        //$AbsencePresenceResultIndex->assertSee('user_id',$data["user_id"]);
        //dd("id user is: " , $data["user_id"] ," \n\r" , $AbsencePresenceResultIndex->decodeResponseJson());
        $AbsencePresenceResultIndex->assertSee(isset($data["user_id"]));     
    }
    public function test_AbsencePresenceStore()
    {
        $data= AbsencePresence::factory()->make(); 
      //$data=AbsencePresence::factory()->for(User::factory())->make();
       //dd($AbsencePresence);
       //$this->assertTrue(isset($AbsencePresence));
       //$this->assertTrue( $AbsencePresence->user  instanceof User);   
      //   $absencepresence=self::AbsencePresenceData();
      // // dd($absencepresence["mobile"]);
         $response = $this->post(route('AbsencePresence.store'), $data->toArray() );
         $this->assertGreaterThan(0,AbsencePresence::all()->count());        
       // $this->assertDatabaseCount('years', 1);
       $this->assertDatabaseHas('absence_presences', [
        'user_id' => $data["user_id"],
        'course_session_id' => $data["course_session_id"],
        'teacher_id' => $data["teacher_id"],
        'status' => $data["status"],
        ]);
        $absencePresence_response = AbsencePresence::where('user_id', $data["user_id"])
        ->where('course_session_id', $data["course_session_id"])
        ->where('teacher_id', $data["teacher_id"])
        ->where('status', $data["status"])
        ->first();
         $this->assertNotNull($absencePresence_response);      
      //  // dd($response["id"]);
      //   //$absencepresences = AbsencePresence::factory()->count(3)->make();
      //   $this->assertGreaterThan(0,AbsencePresence::all()->count());
      //  // $this->assertDatabaseCount('absencepresences', 1);
      //  $this->assertDatabaseHas('absencepresences', [
      //   //'type' => $absencepresence["type"],
      //   //'lesson' => $absencepresence["lesson"],
      //   'users_id' => $absencepresence["user_id"],
      //   'course_sessions_id' => $absencepresence["course_session_id"],
      //   'teachers_id' => $absencepresence["teacher_id"],
      //   'status' => $absencepresence["status"],

      //   ]);
      //   $absencepresence_response =
      //   AbsencePresence::where('users_id', $absencepresence["user_id"])
      //   ->where('status', $absencepresence["status"])
      //   ->where('course_sessions_id', $absencepresence["course_session_id"])
      //   ->where('teachers_id', $absencepresence["teacher_id"])
      //   ->where('users_id', $absencepresence["user_id"])
      //   ->first();
      //    $this->assertNotNull($absencepresence_response);
    }
    public function test_AbsencePresenceUpdate()
    {
       // $newAbsencePresence=self::absencePresenceData();
        $data= AbsencePresence::factory()->make(); 
        $responseCreate = $this->post(route('AbsencePresence.store'), $data->toArray());
        $anotherAbsencePresence=self::absencePresenceData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        //dd($anotherAbsencePresence);
        $responseUpdate = $this->put(route('AbsencePresence.update', $responseCreate['id']),$anotherAbsencePresence);
        $absencepresenceFounded =AbsencePresence::where('user_id', $anotherAbsencePresence["user_id"])
        ->where('status', $anotherAbsencePresence["status"])
        ->where('course_session_id', $anotherAbsencePresence["course_session_id"])
        ->where('teacher_id', $anotherAbsencePresence["teacher_id"])       
        ->first();
        //dd($absencepresenceFounded);
        $this->assertNotNull($absencepresenceFounded);
        // $this->assertAuthenticatedAs($absencepresence);
    }
    public function test_AbsencePresenceDelete()
    {
        $data= AbsencePresence::factory()->make();
        //$absencepresence=self::AbsencePresenceData();
        $response = $this->post(route('AbsencePresence.store'), $data->toArray() );
        $responseDelete = $this->delete(route('AbsencePresence.destroy', $response["id"]));
        $AbsencePresenceFound= AbsencePresence::withTrashed()->find($response["id"]);
       //dd($AbsencePresenceFound);
        $this->assertSoftDeleted($AbsencePresenceFound);
    }
    public  function  absencePresenceData()
    {

        $user_id=$this->faker->randomDigit;//$this->faker->randomDigit;
        $course_session_id= $this->faker->randomDigit;
        $teacher_id=$this->faker->randomDigit;
        $status=['dellay','absent','present'];

        $absencepresence=[
            'user_id' => $user_id,
            'teacher_id' => $teacher_id,
            'course_session_id' => $course_session_id,
            'status' => $status[rand(0,2)]
        ];
        return $absencepresence;
    }
}