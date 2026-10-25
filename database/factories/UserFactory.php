<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => rand(0,1) == 1 ? fake()->name() : null,
            'email' => rand(0,1) == 1 ? fake()->unique()->safeEmail() : null,
            'phone' => '09' . rand(111111111,999999999),
            'password' =>  rand(0,1) == 1 ? Hash::make(12345678910) : null,
            'phone_active_at' => rand(0,1) == 1 ? fake()->dateTime() : null,
            'email_active_at' =>  rand(0,1) == 1 ? fake()->dateTime() : null
        ];
    }
}
