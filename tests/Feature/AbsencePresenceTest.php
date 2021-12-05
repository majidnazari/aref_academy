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
   // use RefreshDatabase;
    //use User;
    //use Fault;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_AbsencePresenceFetchAll()
    {
      $AbsencePresence=AbsencePresence::factory()->for(User::factory())->create();

      $this->assertTrue(isset( $AbsencePresence->user->id));
      $this->assertTrue( $AbsencePresence->user  instanceof User);
       // dd($AbsencePresence);
       // $absencepresence=self::AbsencePresenceData();
        //dd($absencepresence);
      //   $response_create = $this->post(route('AbsencePresence.store'),$absencepresence);
      //   $response_getAll = $this->get(route('AbsencePresence.index'));
      //   //dd($response_create->decodeResponseJson());

      // //dd($absencepresence["user_id"]);
      //  $response_getAll->assertSee($absencepresence["user_id"]);
      //  //$response_getAll->assertSee($absencepresence["year_id"]);
      //  $response_getAll->assertSee($absencepresence["teacher_id"]);
      //  $response_getAll->assertSee($absencepresence["course_session_id"]);
      //  $response_getAll->assertSee($absencepresence["status"]);
    }
    // public function test_AbsencePresenceStore()
    // {
    //     $absencepresence=self::AbsencePresenceData();
    //   // dd($absencepresence["mobile"]);
    //     $response = $this->post(route('AbsencePresence.store'), $absencepresence );
    //    // dd($response["id"]);
    //     //$absencepresences = AbsencePresence::factory()->count(3)->make();
    //     $this->assertGreaterThan(0,AbsencePresence::all()->count());
    //    // $this->assertDatabaseCount('absencepresences', 1);
    //    $this->assertDatabaseHas('absencepresences', [
    //     //'type' => $absencepresence["type"],
    //     //'lesson' => $absencepresence["lesson"],
    //     'users_id' => $absencepresence["user_id"],
    //     'course_sessions_id' => $absencepresence["course_session_id"],
    //     'teachers_id' => $absencepresence["teacher_id"],
    //     'status' => $absencepresence["status"],

    //     ]);
    //     $absencepresence_response =
    //     AbsencePresence::where('users_id', $absencepresence["user_id"])
    //     ->where('status', $absencepresence["status"])
    //     ->where('course_sessions_id', $absencepresence["course_session_id"])
    //     ->where('teachers_id', $absencepresence["teacher_id"])
    //     ->where('users_id', $absencepresence["user_id"])
    //     ->first();
    //      $this->assertNotNull($absencepresence_response);
    // }
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
    // public  function  AbsencePresenceData()
    // {

    //     $user_id=3;//factory(App\Models\User::class);//$this->faker->randomDigit;
    //     $course_session_id= $this->faker->randomDigit;
    //     $teacher_id=$this->faker->randomDigit;
    //     $status=['dellay','absent','present'];

    //     $absencepresence=[
    //         'user_id' => $user_id,
    //         'teacher_id' => $teacher_id,
    //         'course_session_id' => $course_session_id,
    //         'status' => $status
    //     ];
    //     return $absencepresence;
    // }
}
