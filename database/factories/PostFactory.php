<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'image' => fake()->imageUrl(),
            'body' => fake()->text(200),
            'author_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'status' => fake()->numberBetween(1,2),
            'published_at' => fake()->dateTime()
        ];
    }
}
