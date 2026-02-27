<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Forum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ForumAccessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory();
        $forum = Forum::inRandomOrder()->first() ?? Forum::factory();
        return [
            'forum_id' => $forum,
            'user_id' => $user,
        ];
    }
}
