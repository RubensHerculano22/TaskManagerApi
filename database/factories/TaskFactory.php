<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition()
    {
        return [
            'category_id' => Category::all()->random(),
            'user_id' => User::all()->random(),
            'title' => fake()->name(),
            'description' => fake()->text(),
            'date_limit' => fake()->date('Y-m-d'),
            'done' => fake()->randomNumber(1, true)
        ];
    }
}
