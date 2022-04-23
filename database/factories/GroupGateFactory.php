<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\GroupGate;
use App\Models\Group;
use App\Models\Gate;
use App\Models\AbsencePresence;
use Carbon\Carbon;

class GroupGateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
       
        $group=$this->faker->randomElement(Group::pluck('id'));// User::factory()->create();
        if($group===null)
        {
            $group= Group::factory()->create();
            $group=$group->id;
        }
        $gate=$this->faker->randomElement(Gate::pluck('id'));// User::factory()->create();
        if($gate===null)
        {
            $gateuser= Gate::factory()->create();
            $gate=$gateuser->id;
        }
       $name=$this->faker->firstName();
        return  [
            'user_id_created' => $user,
            'user_id' => $user,			
			'group_id' => $group,			
			'gate_id' => $gate           
        ];
    }
}
