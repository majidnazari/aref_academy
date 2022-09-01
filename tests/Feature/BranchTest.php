<?php

namespace Tests\Feature;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_getOneBranch()
    // {
    //     $branch=Branch::factory()->make()->toArray();
    //     $branch_created=Branch::create($branch);

    //     $findUser=Branch::where($branch)->first();
    //     $this->assertNotNull($findUser);
    // }
    public function test_getAllBranche()
    {
        $count=rand(2,5);
        $branches=Branch::factory($count)->create();
        $this->assertGreaterThanOrEqual($count,Branch::all()->count());
    }
    public function test_createBranch()
    {
       $branch=Branch::factory()->make()->toArray();
       Branch::create($branch);

       $this->assertDatabaseHas('branches',$branch);

    }

    public function test_updateBranch()
    {
        $branch=Branch::factory()->make()->toArray();
        Branch::create($branch);

        $new_branch=Branch::factory()->make()->toArray();
        Branch::where($branch)->update($new_branch);

        $this->assertDatabaseHas('branches',$new_branch);
    }
    public function test_deleteBranch()
    {
        $branch=Branch::factory()->make()->toArray();
        $branch_created=Branch::create($branch);

        $this->assertDatabaseHas('branches',$branch);

        Branch::where($branch)->delete();

        $this->assertSoftDeleted('branches',$branch);


    }
}
