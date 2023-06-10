<?php

namespace Tests\Feature;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_getOneUser()
    // {
    //     $user_created = User::factory()
    //         ->for(Branch::factory())
    //         ->create();
    //     $findUser = User::where('id', $user_created->id)->first();
    //     $user_tmp = $findUser->toArray();
    //     $user_tmp["password"] = $user_created->password;
    //     $user_tmp["created_at"] = $findUser->created_at->format("Y-m-d H:i:s");
    //     $user_tmp["updated_at"] = $findUser->updated_at->format("Y-m-d H:i:s");

    //     $this->assertDatabaseHas('users', $user_tmp);
        
    // }
    public function test_getAllUsers()
    {
        $count=rand(1,5);
        $user_created = User::factory($count)
        ->for(Branch::factory())
        ->create();       
        $this->assertGreaterThanOrEqual($count,User::all()->count());

    }
    public function test_createUser()
    {
        $user_created = User::factory()
            ->for(Branch::factory())
            ->create(["group_id" => 1]);
        $this->assertTrue(isset($user_created->branch->id));
        $this->assertTrue($user_created->branch instanceof Branch);       
    }

    public function test_updateUser()
    {
        $user_created = User::factory()
            ->for(Branch::factory())
            ->create();
        $user_changed = User::factory()->make()->toArray();

        $result = User::where('id', $user_created->id)->update($user_changed);
        $this->assertDatabaseHas('users', $user_changed);
        
    }
    public function test_deleteUser()
    {
        $user_created = User::factory()
            ->for(Branch::factory())
            ->create();        
        User::where('id', $user_created->id)->delete();
        $UserFound = User::withTrashed()->find($user_created->id);

        $this->assertSoftDeleted($UserFound);           
    }
    public  function  userData()
    {
        $arrayValues = ['admin', 'acceptor', 'financial', 'manager'];
        $email = $this->faker->unique()->safeEmail();
        $mobile = $this->faker->regexify('09[0-9]{9}');
        $user = [
            'user_id_creator' => $this->faker->randomNumber(),
            'group_id' => $this->faker->random(1, 5),
            'branch_id' => 1,
            'email' => $email,
            'password' => Hash::make('12345678'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,        

        ];
        return $user;
    }
}
