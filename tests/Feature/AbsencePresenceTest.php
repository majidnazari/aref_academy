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
        $data=self::AbsencePresenceData();
        //dd($data["user_id"]);
        $AbsencePresenceResultStore=$this->post(route('AbsencePresence.store'),$data);
        $AbsencePresenceResultIndex=$this->get(route('AbsencePresence.index'));
        //dd($AbsencePresenceResultStore->decodeResponseJson());
        //dd("id user is: " , $data["user_id"] ," \n\r" , $AbsencePresenceResultIndex->decodeResponseJson());
        //$AbsencePresenceResultIndex->assertSee('user_id',$data["user_id"]);
        dd("id user is: " , $data["user_id"] ," \n\r" , $AbsencePresenceResultIndex->decodeResponseJson());
        $AbsencePresenceResultIndex->assertSee(isset($data["user_id"]));
       // dd($data);     
      //  $AbsencePresence=AbsencePresence::factory()->for(User::factory())->create();
      //  $result=AbsencePresence::all();
      //  //dd($AbsencePresence);
        $this->assertTrue(isset($AbsencePresence));
        $this->assertTrue( $AbsencePresence->user  instanceof User);   
    }
    public function test_AbsencePresenceStore()
    {
      $AbsencePresence=AbsencePresence::factory()->for(User::factory())->create();
       //dd($AbsencePresence);
       $this->assertTrue(isset($AbsencePresence));
       $this->assertTrue( $AbsencePresence->user  instanceof User);   
      //   $absencepresence=self::AbsencePresenceData();
      // // dd($absencepresence["mobile"]);
      //   $response = $this->post(route('AbsencePresence.store'), $absencepresence );
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
    // public function test_AbsencePresenceUpdate()
    // {
    //     $newAbsencePresence=self::AbsencePresenceData();
    //     $responseCreate = $this->post(route('AbsencePresence.store'), $newAbsencePresence );
    //     $anotherAbsencePresence=self::AbsencePresenceData();
    //    // $email= $this->faker->unique()->safeEmail();
    //     //$mobile=$this->faker->regexify('09[0-9]{9}');
    //     $responseUpdate = $this->put(route('AbsencePresence.update', $responseCreate['id']),$anotherAbsencePresence);
    //     $absencepresenceFounded =
    //     AbsencePresence::where('users_id', $absencepresence["user_id"])
    //     ->where('status', $absencepresence["status"])
    //     ->where('course_sessions_id', $absencepresence["course_session_id"])
    //     ->where('teachers_id', $absencepresence["teacher_id"])
    //     ->where('users_id', $absencepresence["user_id"])
    //     ->first();
    //    // dd($anotherAbsencePresence,$absencepresenceFounded);
    //     $this->assertNotNull($absencepresenceFounded);
    //     // $this->assertAuthenticatedAs($absencepresence);
    // }
    // public function test_AbsencePresenceDelete()
    // {
    //     $absencepresence=self::AbsencePresenceData();
    //     $response = $this->post(route('AbsencePresence.store'), $absencepresence );
    //     $responseDelete = $this->delete(route('AbsencePresence.destroy', $response["id"]));
    //     $AbsencePresenceFound= AbsencePresence::withTrashed()->find($response["id"]);
    //    //dd($AbsencePresenceFound);
    //     $this->assertSoftDeleted($AbsencePresenceFound);
    // }
    public  function  AbsencePresenceData()
    {

        $user=User::factory()->create();//$this->faker->randomDigit;
        $course_session_id= $this->faker->randomDigit;
        $teacher_id=$this->faker->randomDigit;
        $status=['dellay','absent','present'];

        $absencepresence=[
            'user_id' => $user->id,
            'teacher_id' => $teacher_id,
            'course_session_id' => $course_session_id,
            'status' => $status[rand(0,2)]
        ];
        return $absencepresence;
    }
}
