<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
               // UserSeeder::class,
            GroupSeeder::class,
            MenuSeeder::class,
            GroupMenusSeeder::class,
            //GroupGateSeeder::class,
              //  BranchSeeder::class,
              //  BranchClassRoomSeeder::class,
            SqlFileSeeder::class,
            //Sql_menu_seeder_FileSeeder::class
        ]);
    }
}
