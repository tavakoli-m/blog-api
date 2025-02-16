<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
            'title' => str()->random(20),
            'slug' => str()->random(20),
            'body' => str()->random(200),
            'image' =>  str()->random(200),
            'category_id' => Category::all()->random()->id
        ];
    }
}
