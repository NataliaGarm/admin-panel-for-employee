<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;

class DatabaseSeeder extends Seeder
{
    //use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //Position::factory(200)->create();

        $this->call([
            //UserSeeder::class,
            PositionSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
