<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'title' => fake()->sentence,
        'description' => fake()->paragraph,
        'status' => fake()->randomElement(['Open']),
        'priority' => fake()->randomElement(['High', 'Medium', 'Low']),
        'creator_id' => User::inRandomOrder()->first()->id,
        'category_id' => Category::inRandomOrder()->first()->id,
        'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
