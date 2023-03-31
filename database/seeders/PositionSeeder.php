<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::factory(5)->create();
    }
}
