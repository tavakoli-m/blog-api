<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCanLoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        User::factory()->state([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('hey-MAN2078')
        ])->create();

        $response = $this->post('/api/auth/login',[
            'email' => 'admin@gmail.com',
            'password' => 'hey-MAN2078',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);

        $response->assertCookie('auth_token');
    }
}
