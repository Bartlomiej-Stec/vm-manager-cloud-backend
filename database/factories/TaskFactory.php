<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'level' => $this->faker->randomElement(['easy', 'medium', 'hard', 'insane']),
            'input' => $this->faker->paragraph,
            'output' => $this->faker->paragraph,
            'code' => $this->faker->paragraph,
            'created_by' => User::factory(), 
        ];
    }
}
