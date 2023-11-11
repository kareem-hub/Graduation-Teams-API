<?php

namespace Database\Factories;

use App\Models\TeamType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'title' => fake()->unique()->text(10),
            'body' => fake()->text(20),
            'team_type_id' => TeamType::inRandomOrder()->value('id'),
            'published' => rand(0, 1),
            'members' => rand(1, 10)
        ];
    }
}
