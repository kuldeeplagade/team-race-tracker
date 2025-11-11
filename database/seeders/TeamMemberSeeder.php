<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team1 = Team::where('team_name', 'Red Hawks')->first();
        $team2 = Team::where('team_name', 'Blue Falcons')->first();
         $team3 = Team::where('team_name', 'Green Panthers')->first();

        $team1->members()->createMany([
            ['member_name' => 'John Miller'],
            ['member_name' => 'Sara Lee'],
        ]);

        $team2->members()->createMany([
            ['member_name' => 'Amit Rao'],
            ['member_name' => 'Leena Patel'],
        ]);

        $team3->members()->createMany([
            ['member_name' => 'Ravi Kumar'],
            ['member_name' => 'Priya Shah'],
        ]); 
    }

}
