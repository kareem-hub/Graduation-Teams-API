<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Rating;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(TeamTypeSeeder::class);

        User::factory(10)->create();
        Team::factory(10)->create();
        Rating::factory(50)->create();
    }
}
