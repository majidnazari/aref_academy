<?php

namespace Database\Factories;

use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class YearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {  
        // $year_name="";     
        // do
        // {
        //     $year_name= $this->faker->unique->numberBetween(1300,1500);
        // }
        // while(Year::where('name',$year_name)->first()!==null);
        //dd($year_name);
        // $year_name=$this->faker->randomElement(Year::pluck('name'));
        // //dd($year_name);
        // if($year_name==null){
        //     $year_name= $this->faker->unique->numberBetween(1400,1420);
        //     $year_name=$year_name;
        // }
        return [
                    "name"    => $this->faker->unique->numberBetween(1400,1420),//$this->faker->name(),
                    "active" => $this->faker->numberBetween(0,1), //true,//$this->faker->boolean,
        ];
    }
}
