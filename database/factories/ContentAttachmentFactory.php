<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentAttachment>
 */
class ContentAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $Content = Content::inRandomOrder()->first() ?? Content::factory();
        return [
            'file' => $this->faker->word,
            'content_id' => $Content->id
        ];
    }
}
