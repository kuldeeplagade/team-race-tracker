<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database. All Call the all seeder class here 
     */
    public function run(): void
    {
        $this->call([
            TeamSeeder::class,
            RaceSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
