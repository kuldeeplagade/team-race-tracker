<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Race;
use App\Models\RaceCheckpoint;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Race 1
        $r1 = Race::create(['race_name' => 'Mountain Trek', 'description' => 'Trek to the summit']);
        $r1->checkpoints()->createMany([
            ['checkpoint_name' => 'Start Point', 'order_no' => 1],
            ['checkpoint_name' => 'Hill Base', 'order_no' => 2],
            ['checkpoint_name' => 'River Crossing', 'order_no' => 3],
            ['checkpoint_name' => 'Summit (End)', 'order_no' => 4],
        ]);

        // Race 2
        $r2 = Race::create(['race_name' => 'River Challenge', 'description' => 'Cross river and back']);
        $r2->checkpoints()->createMany([
            ['checkpoint_name' => 'Start Point', 'order_no' => 1],
            ['checkpoint_name' => 'Wetlands', 'order_no' => 2],
            ['checkpoint_name' => 'Bridge', 'order_no' => 3],
            ['checkpoint_name' => 'End Point', 'order_no' => 4],
        ]);
    }

}
