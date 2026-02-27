<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory();
        $content = Content::inRandomOrder()->first() ?? Content::factory();

        return [
            'user_id' => $user,
            'content_id' => $content,
            'text' => $this->faker->word,
        ];
    }
}
