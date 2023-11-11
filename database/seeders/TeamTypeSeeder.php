<?php

namespace Database\Seeders;

use App\Models\TeamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team_types = [
            [
                'name' => 'general'
            ],
            [
                'name' => 'private'
            ]
        ];

        TeamType::insert($team_types);
    }
}
