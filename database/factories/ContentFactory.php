<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory();


        return [
            'title' => $this->faker->word,
            'desc' => $this->faker->paragraphs(5, true),
            'user_id' => $user->id,
            'views' => fake()->numberBetween(1,50),
        ];
    }
}
