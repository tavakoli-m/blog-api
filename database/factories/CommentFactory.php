<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
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
        return [
            'body' => fake()->text(),
            'user_id' =>  User::factory()->create()->id,
            'post_id' => Post::factory()->create()->id,
            'status' => fake()->numberBetween(1,2)
        ];
    }
}
